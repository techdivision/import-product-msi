<?php

/**
 * TechDivision\Import\Product\Msi\Observers\ProductSourceItemObserver
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Msi\Observers;

use TechDivision\Import\Product\Msi\Utils\ColumnKeys;
use TechDivision\Import\Product\Observers\AbstractProductImportObserver;

/**
 * Observer that extracts the MSI source item data to a specific CSV file.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */
class ProductSourceItemObserver extends AbstractProductImportObserver
{

    /**
     * The artefact type.
     *
     * @var string
     */
    const ARTEFACT_TYPE = 'inventory-msi';

    /**
     * Process the observer's business logic.
     *
     * @return array The processed row
     */
    protected function process()
    {

        // query whether or not, we've found a new SKU => means we've found a new product
        if ($this->hasBeenProcessed($this->getValue(ColumnKeys::SKU))) {
            return;
        }

        // initialize the array for the artefacts
        // and the default values for the MSI data
        $artefacts = array();
        $defaultValue = array();

        // initialize a default value in case the column with the MSI
        // data is NOT available, that looks like
        //   source_code=default,status=1,quantity=<value-from-column-qty-if-available>
        if ($this->hasHeader(ColumnKeys::INVENTORY_SOURCE_ITEMS) === false) {
            $defaultValue = array(
                sprintf(
                    '%s=default,%s=1,%s=%d',
                    ColumnKeys::SOURCE_CODE,
                    ColumnKeys::STATUS,
                    ColumnKeys::QUANTITY,
                    $this->hasValue(ColumnKeys::QTY) ? $this->getValue(ColumnKeys::QTY, 0) : 0
                )
            );
        }

        // unserialize the inventory source item data from the column that looks like
        //   source_code=default,quantity=10.0,status=1|source_code=default,quantity=11.0,status=0
        $msiInventorySources = $this->getValue(ColumnKeys::INVENTORY_SOURCE_ITEMS, $defaultValue, function ($value) {
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
     * Create's and return's a new empty artefact entity.
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
