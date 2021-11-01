<?php

/**
 * TechDivision\Import\Product\Msi\Utils\SqlStatements
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

use TechDivision\Import\Product\Msi\Utils\SqlStatementKeys;

/**
 * Repository class with the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */
class SqlStatementRepository extends \TechDivision\Import\Product\Repositories\SqlStatementRepository
{

    /**
     * The SQL statements.
     *
     * @var array
     */
    private $statements = array(
        SqlStatementKeys::INVENTORY_SOURCE_ITEM =>
            'SELECT *
               FROM ${table:inventory_source_item}
              WHERE source_item_id = :source_item_id',
        SqlStatementKeys::INVENTORY_SOURCES =>
            'SELECT *
               FROM ${table:inventory_source}',
        SqlStatementKeys::INVENTORY_SOURCE_ITEMS =>
            'SELECT *
               FROM ${table:inventory_source_item}',
        SqlStatementKeys::INVENTORY_SOURCE_ITEM_BY_SKU_AND_SOURCE_CODE =>
            'SELECT *
               FROM ${table:inventory_source_item}
              WHERE sku = :sku
                AND source_code = :source_code',
        SqlStatementKeys::CREATE_INVENTORY_SOURCE_ITEM =>
            'INSERT
               INTO ${table:inventory_source_item}
                    (source_code,
                     sku,
                     quantity,
                     status)
             VALUES (:source_code,
                     :sku,
                     :quantity,
                     :status)',
        SqlStatementKeys::UPDATE_INVENTORY_SOURCE_ITEM =>
            'UPDATE ${table:inventory_source_item}
                SET source_code = :source_code,
                    sku = :sku,
                    quantity = :quantity,
                    status = :status
              WHERE source_item_id = :source_item_id',
        SqlStatementKeys::DELETE_INVENTORY_SOURCE_ITEM =>
            'DELETE
               FROM ${table:inventory_source_item}
              WHERE source_item_id = :source_item_id',
        SqlStatementKeys::DELETE_INVENTORY_SOURCE_ITEM_BY_SKU_AND_SOURCE_CODE =>
            'DELETE
               FROM ${table:inventory_source_item}
              WHERE sku = :sku
                AND source_code = :source_code'
    );

    /**
     * Initializes the SQL statement repository with the primary key and table prefix utility.
     *
     * @param \IteratorAggregate<\TechDivision\Import\Dbal\Utils\SqlCompilerInterface> $compilers The array with the compiler instances
     */
    public function __construct(\IteratorAggregate $compilers)
    {

        // pass primary key + table prefix utility to parent instance
        parent::__construct($compilers);

        // compile the SQL statements
        $this->compile($this->statements);
    }
}
