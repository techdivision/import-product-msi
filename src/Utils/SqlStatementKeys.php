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

namespace TechDivision\Import\Product\Msi\Utils;

/**
 * Utility class with the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
