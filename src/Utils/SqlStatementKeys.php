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

namespace TechDivision\Import\Product\Msi\Utils;

/**
 * Utility class with the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */
class SqlStatementKeys extends \TechDivision\Import\Product\Utils\SqlStatementKeys
{

    /**
     * The SQL statement to create a MSI inventory source item.
     *
     * @var string
     */
    const CREATE_INVENTORY_SOURCE_ITEM = 'create.inventory_source_item';

    /**
     * The SQL statement to update a MSI inventory source item.
     *
     * @var string
     */
    const UPDATE_INVENTORY_SOURCE_ITEM = 'update.inventory_source_item';

    /**
     * The SQL statement to delete a MSI inventory source item.
     *
     * @var string
     */
    const DELETE_INVENTORY_SOURCE_ITEM = 'delete.inventory_source_item';

    /**
     * The SQL statement to delete a MSI inventory source item by its SKU and source code.
     *
     * @var string
     */
    const DELETE_INVENTORY_SOURCE_ITEM_BY_SKU_AND_SOURCE_CODE = 'delete.inventory_source_item.by.sku.and.source_code';

    /**
     * The SQL statement to load the available MSI inventory sources.
     *
     * @var string
     */
    const INVENTORY_SOURCES = 'inventory_sources';

    /**
     * The SQL statement to load a MSI inventory source item by its source item ID.
     *
     * @var string
     */
    const INVENTORY_SOURCE_ITEM = 'inventory_source_item';

    /**
     * The SQL statement to load the available MSI inventory source items.
     *
     * @var string
     */
    const INVENTORY_SOURCE_ITEMS = 'inventory_source_items';

    /**
     * The SQL statement to load a MSI inventory source item by its SKU and source code.
     *
     * @var string
     */
    const INVENTORY_SOURCE_ITEM_BY_SKU_AND_SOURCE_CODE = 'inventory_source_item.by.sku.and.source_code';
}
