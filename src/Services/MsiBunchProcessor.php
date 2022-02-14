<?php

/**
 * TechDivision\Import\Product\Msi\Services\MsiBunchProcessor
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

use TechDivision\Import\Dbal\Actions\ActionInterface;
use TechDivision\Import\Dbal\Connection\ConnectionInterface;
use TechDivision\Import\Product\Msi\Repositories\InventorySourceRepositoryInterface;
use TechDivision\Import\Product\Msi\Repositories\InventorySourceItemRepositoryInterface;
use TechDivision\Import\Product\Repositories\ProductRepositoryInterface;

/**
 * The inventory source item bunch processor implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */
class MsiBunchProcessor implements MsiBunchProcessorInterface
{
    /**
     * The repository to load the products with.
     *
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * A PDO connection initialized with the values from the Doctrine EntityManager.
     *
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * The repository to access inventory sources.
     *
     * @var InventorySourceRepositoryInterface
     */
    protected $inventorySourceRepository;

    /**
     * The repository to access inventory source items.
     *
     * @var InventorySourceItemRepositoryInterface
     */
    protected $inventorySourceItemRepository;

    /**
     * The action for product CRUD methods.
     *
     * @var ActionInterface
     */
    protected $inventorySourceItemAction;

    /**
     * Initialize the processor with the necessary assembler and repository instances.
     *
     * @param ConnectionInterface                    $connection                    The connection to use
     * @param InventorySourceRepositoryInterface     $inventorySourceRepository     The inventory source repository instance
     * @param InventorySourceItemRepositoryInterface $inventorySourceItemRepository The inventory source item repository instance
     * @param ActionInterface                        $inventorySourceItemAction     The inventory source item action instance
     * @param ProductRepositoryInterface             $productRepository             The product source repository instance
     */
    public function __construct(
        ConnectionInterface $connection,
        InventorySourceRepositoryInterface $inventorySourceRepository,
        InventorySourceItemRepositoryInterface $inventorySourceItemRepository,
        ActionInterface $inventorySourceItemAction,
        ProductRepositoryInterface $productRepository
    ) {
        $this->setConnection($connection);
        $this->setInventorySourceRepository($inventorySourceRepository);
        $this->setInventorySourceItemRepository($inventorySourceItemRepository);
        $this->setInventorySourceItemAction($inventorySourceItemAction);
        $this->setProductRepository($productRepository);
    }

    /**
     * Set's the passed connection.
     *
     * @param ConnectionInterface $connection The connection to set
     *
     * @return void
     */
    public function setConnection(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Return's the connection.
     *
     * @return ConnectionInterface The connection instance
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Turns off autocommit mode. While autocommit mode is turned off, changes made to the database via the PDO
     * object instance are not committed until you end the transaction by calling ProductProcessor::commit().
     * Calling ProductProcessor::rollBack() will roll back all changes to the database and return the connection
     * to autocommit mode.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.begintransaction.php
     */
    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    /**
     * Commits a transaction, returning the database connection to autocommit mode until the next call to
     * ProductProcessor::beginTransaction() starts a new transaction.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.commit.php
     */
    public function commit()
    {
        return $this->connection->commit();
    }

    /**
     * Rolls back the current transaction, as initiated by ProductProcessor::beginTransaction().
     *
     * If the database was set to autocommit mode, this function will restore autocommit mode after it has
     * rolled back the transaction.
     *
     * Some databases, including MySQL, automatically issue an implicit COMMIT when a database definition
     * language (DDL) statement such as DROP TABLE or CREATE TABLE is issued within a transaction. The implicit
     * COMMIT will prevent you from rolling back any other changes within the transaction boundary.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.rollback.php
     */
    public function rollBack()
    {
        return $this->connection->rollBack();
    }

    /**
     * Set's the repository to load the inventory sources with.
     *
     * @param InventorySourceRepositoryInterface $inventorySourceRepository The repository instance
     *
     * @return void
     */
    public function setInventorySourceRepository(InventorySourceRepositoryInterface $inventorySourceRepository)
    {
        $this->inventorySourceRepository = $inventorySourceRepository;
    }

    /**
     * Return's the repository to load the inventory sources with.
     *
     * @return InventorySourceItemRepositoryInterface The repository instance
     */
    public function getInventorySourceRepository()
    {
        return $this->inventorySourceRepository;
    }

    /**
     * Set's the repository to load the inventory source items with.
     *
     * @param InventorySourceItemRepositoryInterface $inventorySourceItemRepository The repository instance
     *
     * @return void
     */
    public function setInventorySourceItemRepository(InventorySourceItemRepositoryInterface $inventorySourceItemRepository)
    {
        $this->inventorySourceItemRepository = $inventorySourceItemRepository;
    }

    /**
     * Return's the repository to load the inventory source items with.
     *
     * @return InventorySourceItemRepositoryInterface The repository instance
     */
    public function getInventorySourceItemRepository()
    {
        return $this->inventorySourceItemRepository;
    }

    /**
     * Set's the action with the inventory source item CRUD methods.
     *
     * @param ActionInterface $inventorySourceItemAction The action instance
     *
     * @return void
     */
    public function setInventorySourceItemAction(ActionInterface $inventorySourceItemAction)
    {
        $this->inventorySourceItemAction = $inventorySourceItemAction;
    }

    /**
     * Return's the action with the inventory source item CRUD methods.
     *
     * @return ActionInterface The action instance
     */
    public function getInventorySourceItemAction()
    {
        return $this->inventorySourceItemAction;
    }

    /**
     * Load's the inventory source item with the passed SKU and source code.
     *
     * @param string $sku        The SKU of the inventory source item to return
     * @param string $sourceCode The source code of the inventory source item to return
     *
     * @return array The inventory source item
     */
    public function loadInventorySourceItemBySkuAndSourceCode($sku, $sourceCode)
    {
        return $this->getInventorySourceItemRepository()->findOneBySkuAndSourceCode($sku, $sourceCode);
    }

    /**
     * Load's the available inventory sources.
     *
     * @return array The available inventory sources
     */
    public function loadInventorySources()
    {
        return $this->getInventorySourceRepository()->findAll();
    }

    /**
     * Persist's the passed inventory source item data.
     *
     * @param array       $inventorySourceItem The inventory source item data to persist
     * @param string|null $name                The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistInventorySourceItem($inventorySourceItem, $name = null)
    {
        $this->getInventorySourceItemAction()->persist($inventorySourceItem, $name);
    }

    /**
     * Delete's the entity with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteInventorySourceItem($row, $name = null)
    {
        $this->getInventorySourceItemAction()->delete($row, $name);
    }

    /**
     * Clean-Up the repositories to free memory.
     *
     * @return void
     */
    public function cleanUp()
    {
        // not implemented yet
    }

    /**
     * Load's and return's the product with the passed SKU.
     *
     * @param string $sku The SKU of the product to load
     *
     * @return array The product
     */
    public function loadProduct($sku)
    {
        return $this->getProductRepository()->findOneBySku($sku);
    }

    /**
     * Set's the repository to load the products with.
     *
     * @param ProductRepositoryInterface $productRepository The repository instance
     *
     * @return void
     */
    public function setProductRepository(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Return's the repository to load the products with.
     *
     * @return ProductRepositoryInterface The repository instance
     */
    public function getProductRepository()
    {
        return $this->productRepository;
    }
}
