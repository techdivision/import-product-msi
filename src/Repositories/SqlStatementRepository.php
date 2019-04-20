<?php

/**
 * TechDivision\Import\Product\Msi\Utils\SqlStatements
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

namespace TechDivision\Import\Product\Msi\Repositories;

use TechDivision\Import\Product\Msi\Utils\SqlStatementKeys;

/**
 * Repository class with the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
               FROM inventory_source_item
              WHERE source_item_id = :source_item_id',
        SqlStatementKeys::INVENTORY_SOURCE_ITEMS =>
            'SELECT *
               FROM inventory_source_items',
        SqlStatementKeys::INVENTORY_SOURCE_ITEM_BY_SKU_AND_SOURCE_CODE =>
            'SELECT *
               FROM inventory_source_item
              WHERE sku = :sku
                AND source_code = :source_code',
        SqlStatementKeys::CREATE_INVENTORY_SOURCE_ITEM =>
            'INSERT
               INTO inventory_source_item
                    (source_code,
                     sku,
                     quantity,
                     status)
             VALUES (:source_code,
                     :sku,
                     :quantity,
                     :status)',
        SqlStatementKeys::UPDATE_INVENTORY_SOURCE_ITEM =>
            'UPDATE inventory_source_item
                SET source_code = :source_code,
                    sku = :sku,
                    quantity = :quantity,
                    status = :status
              WHERE source_item_id = :source_item_id',
        SqlStatementKeys::DELETE_INVENTORY_SOURCE_ITEM =>
            'DELETE
               FROM inventory_source_item
              WHERE source_item_id = :source_item_id'
    );

    /**
     * Initialize the the SQL statements.
     */
    public function __construct()
    {

        // call the parent constructor
        parent::__construct();

        // merge the class statements
        foreach ($this->statements as $key => $statement) {
            $this->preparedStatements[$key] = $statement;
        }
    }
}
