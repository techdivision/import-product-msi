<?php

/**
 * TechDivision\Import\Product\Msi\Repositories\InventorySourceItemRepositoryInterface
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Msi\Repositories;

use TechDivision\Import\Dbal\Repositories\RepositoryInterface;

/**
 * Repository implementation to load inventory source item data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */
interface InventorySourceItemRepositoryInterface extends RepositoryInterface
{

    /**
     * Return's the inventory source item with the passed entity ID.
     *
     * @param integer $id The ID of the inventory source item to return
     *
     * @return array|null The inventory source item
     */
    public function load($id);

    /**
     * Load's the inventory source item with the passed SKU and source code.
     *
     * @param string $sku        The SKU of the inventory source item to return
     * @param string $sourceCode The source code of the inventory source item to return
     *
     * @return array The inventory source item
     */
    public function findOneBySkuAndSourceCode($sku, $sourceCode);

    /**
     * Return's the available inventory source items.
     *
     * @return array The available inventory source items
     */
    public function findAll();
}
