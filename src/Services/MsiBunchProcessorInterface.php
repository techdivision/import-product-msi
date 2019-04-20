<?php

/**
 * TechDivision\Import\Product\Msi\Services\MsiBunchProcessorInterface
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

namespace TechDivision\Import\Product\Msi\Services;

/**
 * Interface for an inventory source item bunch processor.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */
interface MsiBunchProcessorInterface
{

    /**
     * Return's the repository to load the inventory source items with.
     *
     * @return \TechDivision\Import\Product\Repositories\StockItemRepositoryInterface The repository instance
     */
    public function getInventorySourceItemRepository();

    /**
     * Return's the action with the inventory source item CRUD methods.
     *
     * @return \TechDivision\Import\Product\Msi\Actions\InventorySourceItemActionInterface The action instance
     */
    public function getInventorySourceItemAction();

    /**
     * Load's the inventory source item with the passed SKU and source code.
     *
     * @param string $sku        The SKU of the inventory source item to return
     * @param string $sourceCode The source code of the inventory source item to return
     *
     * @return array The inventory source item
     */
    public function loadInventorySourceItemBySkuAndSourceCode($sku, $sourceCode);

    /**
     * Persist's the passed inventory source item data.
     *
     * @param array       $inventorySourceItem The inventory source item data to persist
     * @param string|null $name                The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistInventorySourceItem($inventorySourceItem, $name = null);

    /**
     * Delete's the entity with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteInventorySourceItem($row, $name = null);

    /**
     * Clean-Up the repositories to free memory.
     *
     * @return void
     */
    public function cleanUp();
}
