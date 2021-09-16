<?php

/**
 * TechDivision\Import\Product\Msi\Utils\RegistryKeys
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
 * Utility class containing the unique registry keys.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */
class RegistryKeys extends \TechDivision\Import\Product\Utils\RegistryKeys
{

    /**
     * Key for the registry entry containing the SKU => inventory source item ID mapping.
     *
     * @var string
     */
    const SKU_SOURCE_ITEM_ID_MAPPING = 'skuSourceItemIdMapping';
}
