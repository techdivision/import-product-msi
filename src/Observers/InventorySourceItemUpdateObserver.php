<?php

/**
 * TechDivision\Import\Product\Msi\Observers\InventorySourceItemUpdateObserver
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
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Msi\Observers;

use TechDivision\Import\Product\Msi\Utils\MemberNames;

/**
 * Observer that prepares the MSI source item information found in the CSV file.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */
class InventorySourceItemUpdateObserver extends InventorySourceItemObserver
{

    /**
     * Initialize the MSI inventory source item with the passed attributes and returns an instance.
     *
     * @param array $attr The inventory source item attributes
     *
     * @return array The initialized inventory source item
     * @throws \RuntimeException Is thrown, if the attributes can not be initialized
     */
    protected function initializeInventorySourceItem(array $attr)
    {

        // try to load the inventory source item with the given SKU and source code
        if ($entity = $this->loadInventorySourceItemBySkuAndSourceCode($attr[MemberNames::SKU], $attr[MemberNames::SOURCE_CODE])) {
            return $this->mergeEntity($entity, $attr);
        }

        // simply return the attributes
        return $attr;
    }

    /**
     * Return's the inventory source item with the passed SKU and source code.
     *
     * @param string $sku        The SKU of the inventory source item to return
     * @param string $sourceCode The source code of the inventory source item to return
     *
     * @return array The inventory source item to return
     */
    protected function loadInventorySourceItemBySkuAndSourceCode($sku, $sourceCode)
    {
        return $this->getMsiBunchProcessor()->loadInventorySourceItemBySkuAndSourceCode($sku, $sourceCode);
    }
}
