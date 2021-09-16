<?php

/**
 * TechDivision\Import\Product\Msi\Utils\MemberNames
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
 * Utility class containing the entities member names.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */
class MemberNames extends \TechDivision\Import\Product\Utils\MemberNames
{

    /**
     * Name for the member 'status'.
     *
     * @var string
     */
    const STATUS = 'status';

    /**
     * Name for the member 'source_code'.
     *
     * @var string
     */
    const SOURCE_CODE = 'source_code';

    /**
     * Name for the member 'source_item_id'.
     *
     * @var string
     */
    const SOURCE_ITEM_ID = 'source_item_id';

    /**
     * Name for the member 'quantity'.
     *
     * @var string
     */
    const QUANTITY = 'quantity';
}
