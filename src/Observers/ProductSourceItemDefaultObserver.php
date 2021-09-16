<?php

/**
 * TechDivision\Import\Product\Msi\Observers\ProductSourceItemDefaultObserver
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

use TechDivision\Import\Product\Msi\Utils\ColumnKeys;
use TechDivision\Import\Product\Observers\AbstractProductImportObserver;

/**
 * Observer that extracts the MSI source item data to a specific CSV file.
 *
 * @author     Tim Wagner <t.wagner@techdivision.com>
 * @copyright  2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link       https://github.com/techdivision/import-product-msi
 * @link       http://www.techdivision.com
 * @deprecated Since version 13.0.1
 * @see        \TechDivision\Import\Product\Msi\Observers\ProductSourceItemObserver
 */
class ProductSourceItemDefaultObserver extends AbstractProductImportObserver
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

        // initialize the array for the artefacts and the store view codes
        $artefacts = array();

        // create a new artefact with the column information
        $artefacts[] = $this->newArtefact(
            array(
                ColumnKeys::SKU         => $this->getValue(ColumnKeys::SKU),
                ColumnKeys::SOURCE_CODE => 'default',
                ColumnKeys::STATUS      => 1,
                ColumnKeys::QUANTITY    => $this->getValue(ColumnKeys::QTY, 0)
            ),
            array(
                ColumnKeys::SKU         => ColumnKeys::SKU,
                ColumnKeys::SOURCE_CODE => null,
                ColumnKeys::STATUS      => null,
                ColumnKeys::QUANTITY    => ColumnKeys::QTY
            )
        );

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
