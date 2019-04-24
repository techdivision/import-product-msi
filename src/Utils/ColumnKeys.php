<?php

/**
 * TechDivision\Import\Product\Msi\Utils\ColumnKeys
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
 * Utility class containing the CSV column names.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
