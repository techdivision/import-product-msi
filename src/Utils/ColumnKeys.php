<?php

/**
 * TechDivision\Import\Product\Msi\Utils\ColumnKeys
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
 * Utility class containing the CSV column names.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */
class ColumnKeys extends \TechDivision\Import\Product\Utils\ColumnKeys
{

    /**
     * Name for the column 'inventory_source_items'.
     *
     * @var string
     */
    const INVENTORY_SOURCE_ITEMS = 'inventory_source_items';

    /**
     * Name for the column 'quantity'.
     *
     * @var string
     */
    const QUANTITY = 'quantity';

    /**
     * Name for the column 'status'.
     *
     * @var string
     */
    const STATUS = 'status';

    /**
     * Name for the column 'source_code'.
     *
     * @var string
     */
    const SOURCE_CODE = 'source_code';
}
