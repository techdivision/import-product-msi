<?php

/**
 * TechDivision\Import\Product\Msi\Repositories\InventorySourceRepository
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
class InventorySourceRepository extends AbstractRepository implements InventorySourceRepositoryInterface
{

    /**
     * The prepared statement to load a inventory source item with the passed ID.
     *
     * @var \PDOStatement
     */
    protected $inventorySourcesStmt;

    /**
     * Initializes the repository's prepared statements.
     *
     * @return void
     */
    public function init()
    {

        // initialize the prepared statements
        $this->inventorySourcesStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::INVENTORY_SOURCES));
    }

    /**
     * Returns the available inventory sources.
     *
     * @return array The available inventory sources
     */
    public function findAll()
    {

        // initialize the array with the result
        $result = array();

        // load the inventory sources
        $this->inventorySourcesStmt->execute();
        $inventorySources = $this->inventorySourcesStmt->fetchAll(\PDO::FETCH_ASSOC);

        // add the inventory sources to the result using the source code as key
        foreach ($inventorySources as $inventorySource) {
            $result[$inventorySource[MemberNames::SOURCE_CODE]] = $inventorySource;
        }

        // returns the inventory sources
        return $result;
    }
}
