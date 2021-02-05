<?php

/**
 * TechDivision\Import\Product\Msi\Actions\Processors\ProductDeleteProcessor
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

namespace TechDivision\Import\Product\Msi\Actions\Processors;

use TechDivision\Import\Product\Msi\Utils\SqlStatementKeys;
use TechDivision\Import\Actions\Processors\AbstractDeleteProcessor;

/**
 * The MSI inventory source item delete processor implementation.
 *
 * @author     Tim Wagner <t.wagner@techdivision.com>
 * @copyright  2021 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/import-product-msi
 * @link       http://www.techdivision.com
 * @deprecated Since 19.0.0
 * @see        \TechDivision\Import\Actions\Processors\GenericProcessor
 */
class InventorySourceItemDeleteProcessor extends AbstractDeleteProcessor
{

    /**
     * Return's the array with the SQL statements that has to be prepared.
     *
     * @return array The SQL statements to be prepared
     * @see \TechDivision\Import\Actions\Processors\AbstractBaseProcessor::getStatements()
     */
    protected function getStatements()
    {

        // return the array with the SQL statements that has to be prepared
        return array(
            SqlStatementKeys::DELETE_INVENTORY_SOURCE_ITEM                        => $this->loadStatement(SqlStatementKeys::DELETE_INVENTORY_SOURCE_ITEM),
            SqlStatementKeys::DELETE_INVENTORY_SOURCE_ITEM_BY_SKU_AND_SOURCE_CODE => $this->loadStatement(SqlStatementKeys::DELETE_INVENTORY_SOURCE_ITEM_BY_SKU_AND_SOURCE_CODE)
        );
    }
}
