<?php

/**
 * TechDivision\Import\Product\Msi\Observers\ClearInventorySourceItemObserver
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Msi\Observers;

use TechDivision\Import\Product\Msi\Utils\ColumnKeys;
use TechDivision\Import\Product\Msi\Services\MsiBunchProcessorInterface;
use TechDivision\Import\Product\Msi\Utils\MemberNames;
use TechDivision\Import\Product\Msi\Utils\SqlStatementKeys;

/**
 * Observer that removes the MSI product sourch item with the SKU/Source Code found in the CSV file.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */
class ClearInventorySourceItemObserver extends AbstractMsiImportObserver
{

    /**
     * The MSI bunch processor instance.
     *
     * @var \TechDivision\Import\Product\Msi\Services\MsiBunchProcessorInterface
     */
    protected $msiBunchProcessor;

    /**
     * Initialize the observer with the passed MSI bunch processor instance.
     *
     * @param \TechDivision\Import\Product\Msi\Services\MsiBunchProcessorInterface $msiBunchProcessor The MSI bunch processor instance
     */
    public function __construct(MsiBunchProcessorInterface $msiBunchProcessor)
    {
        $this->msiBunchProcessor = $msiBunchProcessor;
    }

    /**
     * Return's the MSI bunch processor instance.
     *
     * @return \TechDivision\Import\Product\Msi\Services\MsiBunchProcessorInterface The MSI bunch processor instance
     */
    protected function getMsiBunchProcessor()
    {
        return $this->msiBunchProcessor;
    }

    /**
     * Process the observer's business logic.
     *
     * @return array The processed row
     */
    protected function process()
    {
        $this->deleteInventorySourceItem(
            array(
                MemberNames::SKU         => $this->getValue(ColumnKeys::SKU),
                MemberNames::SOURCE_CODE => $this->getValue(ColumnKeys::SOURCE_CODE)
            ),
            SqlStatementKeys::DELETE_INVENTORY_SOURCE_ITEM_BY_SKU_AND_SOURCE_CODE
        );
    }

    /**
     * Delete's the entity with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    protected function deleteInventorySourceItem($row, $name = null)
    {
        $this->getMsiBunchProcessor()->deleteInventorySourceItem($row, $name);
    }
}
