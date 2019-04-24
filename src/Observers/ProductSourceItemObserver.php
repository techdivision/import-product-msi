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

/**
 * Observer that extracts the MSI source item data to a specific CSV file.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */
class ProductSourceItemObserver extends AbstractMsiImportObserver
{

    /**
     * The artefact type.
     *
     * @var string
     */
    const ARTEFACT_TYPE = 'product-import-inventory-msi';

    /**
     * Process the observer's business logic.
     *
     * @return array The processed row
     */
    protected function process()
    {

        // initialize the array for the artefacts and the store view codes
        $artefacts = array();

        // Unserialize the inventory source item data from from the column that looks like
        // source_code=default,quantity=10.0,status=1|source_code=default,quantity=11.0,status=0
        $msiInventorySources = $this->getValue(ColumnKeys::INVENTORY_SOURCE_ITEMS, array(), function ($value) {
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
