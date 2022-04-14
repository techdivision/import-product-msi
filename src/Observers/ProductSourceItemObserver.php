<?php

/**
 * TechDivision\Import\Product\Msi\Observers\ProductSourceItemObserver
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Msi\Observers;

use TechDivision\Import\Subjects\SubjectInterface;
use TechDivision\Import\Product\Msi\Utils\ColumnKeys;
use TechDivision\Import\Product\Msi\Utils\MemberNames;
use TechDivision\Import\Observers\ObserverFactoryInterface;
use TechDivision\Import\Product\Observers\AbstractProductImportObserver;
use TechDivision\Import\Product\Msi\Services\MsiBunchProcessorInterface;

/**
 * Observer that extracts the MSI source item data to a specific CSV file.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */
class ProductSourceItemObserver extends AbstractProductImportObserver implements ObserverFactoryInterface
{

    /**
     * The artefact type.
     *
     * @var string
     */
    const ARTEFACT_TYPE = 'inventory-msi';

    /**
     * The bunch processor instance.
     *
     * @var \TechDivision\Import\Product\Msi\Services\MsiBunchProcessorInterface
     */
    protected $processor;

    /**
     * The array for the inventory source templates, used if the column with the
     * inventory source data is NOT part of the actual file.
     *
     * @var array
     */
    protected $templateDefaultValues = array();

    /**
     * Initializes the observer with the bunch processor instance.
     *
     * @param \TechDivision\Import\Product\Msi\Services\MsiBunchProcessorInterface $processor The bunch processor instance
     */
    public function __construct(MsiBunchProcessorInterface $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Will be invoked by the observer visitor when a factory has been defined to create the observer instance.
     *
     * @param \TechDivision\Import\Subjects\SubjectInterface $subject The subject instance
     *
     * @return \TechDivision\Import\Observers\ObserverInterface The observer instance
     */
    public function createObserver(SubjectInterface $subject)
    {

        try {
            // load the available inventory sources
            $inventorySources = $this->getProcessor()->loadInventorySources();
        } catch (\Exception $e) {
            // prepare a log message
            $message = sprintf(
                '"%s"',
                $e->getMessage()
            );
            $subject->getSystemLogger()
                ->error($subject->appendExceptionSuffix($message));
            // set inventorySources as empty
            $inventorySources = [];
        }

        // initialize the template for the inventory source
        // column, used if the column is NOT part of the file
        foreach ($inventorySources as $inventorySource) {
            // initialize the default values
            $defaultValue = array(
                sprintf('%s=%s', ColumnKeys::SOURCE_CODE, $inventorySource[MemberNames::SOURCE_CODE]),
                sprintf('%s=1', ColumnKeys::STATUS),
                sprintf('%s=%%f', ColumnKeys::QUANTITY)
            );
            // concatenate them with the multiple field delimiter and add them to the array with the templates
            $this->templateDefaultValues[] = implode($subject->getMultipleFieldDelimiter(), $defaultValue);
        }

        // return the instance itself
        return $this;
    }

    /**
     *  Return the bunch processor instance.
     *
     * @return \TechDivision\Import\Product\Msi\Services\MsiBunchProcessorInterface The bunch processor instance
     */
    protected function getProcessor()
    {
        return $this->processor;
    }

    /**
     * Process the observer's business logic.
     *
     * @return array The processed row
     */
    protected function process()
    {
        if (empty($this->templateDefaultValues)) {
            return;
        }

        // query whether or not, we've found a new SKU => means we've found a new product
        if ($this->hasBeenProcessed($this->getValue(ColumnKeys::SKU))) {
            return;
        }

        // initialize the array for the artefacts
        // and the default values for the MSI data
        $artefacts = array();
        $defaultValues = array();

        // initialize a default value in case the column with the MSI
        // data is NOT available, that looks like
        //   source_code=default,status=1,quantity=<value-from-column-qty-if-available>
        if ($this->hasHeader(ColumnKeys::INVENTORY_SOURCE_ITEMS) === false) {
            $defaultValues = $this->loadDefaultValues($this->getValue(ColumnKeys::QTY, 0));
        }

        // unserialize the inventory source item data from the column that looks like
        //   source_code=default,quantity=10.0,status=1|source_code=default,quantity=11.0,status=0
        $msiInventorySources = $this->getValue(ColumnKeys::INVENTORY_SOURCE_ITEMS, $defaultValues, function ($value) {
            return $this->explode($value, '|');
        });

        // iterate over the found inventory source items
        foreach ($msiInventorySources as $msiInventorySource) {
            // explode the key => values pairs
            $extractedColumns = $this->explode($msiInventorySource);
            // initialize the array with the column we want to export
            $columns = array(ColumnKeys::SKU => $this->getValue(ColumnKeys::SKU));
            // append the extracted values to the array
            foreach ($extractedColumns as $extractedColumn) {
                // extract key => value pair
                list ($key, $value) = $this->explode($extractedColumn, '=');
                // append the key => value pair
                $columns[$key] = $value;
            }

            // create a new artefact with the column information
            $artefacts[] = $this->newArtefact($columns, array());
        }

        // append the artefacts that has to be exported to the subject
        $this->addArtefacts($artefacts);
    }

    /**
     * Process the template and set the passed quantity for each
     * configured inventory source and return the default values.
     *
     * @param float $qty The quantity to initialize the template with
     *
     * @return array The initialized array with the default values
     */
    protected function loadDefaultValues(float $qty) : array
    {
        return array_map(function ($value) use ($qty) {
            return sprintf($value, $qty);
        }, $this->templateDefaultValues);
    }

    /**
     * Creates and returns a new empty artefact entity.
     *
     * @param array $columns             The array with the column data
     * @param array $originalColumnNames The array with a mapping from the old to the new column names
     *
     * @return array The new artefact entity
     */
    protected function newArtefact(array $columns, array $originalColumnNames)
    {
        return $this->getSubject()->newArtefact($columns, $originalColumnNames);
    }

    /**
     * Add the passed product type artefacts to the product with the
     * last entity ID.
     *
     * @param array $artefacts The product type artefacts
     *
     * @return void
     * @uses \TechDivision\Import\Product\Media\Subjects\MediaSubject::getLastEntityId()
     */
    protected function addArtefacts(array $artefacts)
    {
        $this->getSubject()->addArtefacts(ProductSourceItemObserver::ARTEFACT_TYPE, $artefacts, false);
    }
}
