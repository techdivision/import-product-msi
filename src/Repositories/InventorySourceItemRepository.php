<?php

/**
 * TechDivision\Import\Product\Msi\Repositories\InventorySourceItemRepository
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Msi\Repositories;

use TechDivision\Import\Dbal\Collection\Repositories\AbstractRepository;
use TechDivision\Import\Product\Msi\Utils\MemberNames;
use TechDivision\Import\Product\Msi\Utils\SqlStatementKeys;

/**
 * Repository implementation to load MSI inventory source item data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */
class InventorySourceItemRepository extends AbstractRepository implements InventorySourceItemRepositoryInterface
{

    /**
     * The prepared statement to load a inventory source item with the passed ID.
     *
     * @var \PDOStatement
     */
    protected $inventorySourceItemStmt;

    /**
     * The prepared statement to load a inventory source item with the passed SKU and source code.
     *
     * @var \PDOStatement
     */
    protected $inventorySourceItemBySkuAndSourceCodeStmt;

    /**
     * The prepared statement to load the existing inventory source items.
     *
     * @var \PDOStatement
     */
    protected $inventorySourceItemsStmt;

    /**
     * Initializes the repository's prepared statements.
     *
     * @return void
     */
    public function init()
    {

        // initialize the prepared statements
        $this->inventorySourceItemStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::INVENTORY_SOURCE_ITEM));
        $this->inventorySourceItemBySkuAndSourceCodeStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::INVENTORY_SOURCE_ITEM_BY_SKU_AND_SOURCE_CODE));
        $this->inventorySourceItemsStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::INVENTORY_SOURCE_ITEMS));
    }

    /**
     * Return's the inventory source item with the passed entity ID.
     *
     * @param integer $id The ID of the inventory source item to return
     *
     * @return array|null The inventory source item
     */
    public function load($id)
    {
        // load and return the available products
        $this->inventorySourceItemStmt->execute(array(MemberNames::SOURCE_ITEM_ID => $id));
        return $this->inventorySourceItemStmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Load's the inventory source item with the passed SKU and source code.
     *
     * @param string $sku        The SKU of the inventory source item to return
     * @param string $sourceCode The source code of the inventory source item to return
     *
     * @return array The inventory source item
     */
    public function findOneBySkuAndSourceCode($sku, $sourceCode)
    {

        // initialize the params
        $params = array(
            MemberNames::SKU         => $sku,
            MemberNames::SOURCE_CODE => $sourceCode
        );

        // if not, try to load the inventory source item with the passed SKU/source code
        $this->inventorySourceItemBySkuAndSourceCodeStmt->execute($params);
        return $this->inventorySourceItemBySkuAndSourceCodeStmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Return's the available inventory source items.
     *
     * @return array The available inventory source items
     */
    public function findAll()
    {
        // load and return all the available inventory source items
        $this->inventorySourceItemsStmt->execute();
        return $this->inventorySourceItemsStmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
