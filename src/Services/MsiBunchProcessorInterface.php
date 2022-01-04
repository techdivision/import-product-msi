<?php

/**
 * TechDivision\Import\Product\Msi\Services\MsiBunchProcessorInterface
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Msi\Services;

use TechDivision\Import\Product\Repositories\ProductRepositoryInterface;
use TechDivision\Import\Product\Services\ProductProcessorInterface;

/**
 * Interface for an inventory source item bunch processor.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */
interface MsiBunchProcessorInterface extends ProductProcessorInterface
{

    /**
     * Return's the repository to load the inventory sources with.
     *
     * @return \TechDivision\Import\Product\Msi\Repositories\InventorySourceItemRepositoryInterface The repository instance
     */
    public function getInventorySourceRepository();

    /**
     * Return's the repository to load the inventory source items with.
     *
     * @return \TechDivision\Import\Product\Repositories\StockItemRepositoryInterface The repository instance
     */
    public function getInventorySourceItemRepository();

    /**
     * Return's the action with the inventory source item CRUD methods.
     *
     * @return \TechDivision\Import\Dbal\Actions\ActionInterface The action instance
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
     * Load's the available inventory sources.
     *
     * @return array The available inventory sources
     */
    public function loadInventorySources();

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

    /**
     * Set's the repository to load the products with.
     *
     * @param ProductRepositoryInterface $productRepository The repository instance
     *
     * @return void
     */
    public function setProductRepository(ProductRepositoryInterface $productRepository);

    /**
     * Return's the repository to load the products with.
     *
     * @return ProductRepositoryInterface The repository instance
     */
    public function getProductRepository();

    /**
     * Load's and return's the product with the passed SKU.
     *
     * @param string $sku The SKU of the product to load
     *
     * @return array The product
     */
    public function loadProduct($sku);
}
