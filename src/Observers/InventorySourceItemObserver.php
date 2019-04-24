<?php

/**
 * TechDivision\Import\Product\Msi\Observers\InventorySourceItemObserver
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

namespace TechDivision\Import\Product\Msi\Observers;

use TechDivision\Import\Product\Msi\Utils\ColumnKeys;
use TechDivision\Import\Product\Msi\Utils\MemberNames;
use TechDivision\Import\Product\Msi\Services\MsiBunchProcessorInterface;

/**
 * Observer that prepares the MSI source item information found in the CSV file.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */
class InventorySourceItemObserver extends AbstractMsiImportObserver
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

        // load SKU and inventory source code
        $sku = $this->getValue(ColumnKeys::SKU);
        $sourceCode = $this->getValue(ColumnKeys::SOURCE_CODE);

        // query whether or not, we've found a new SKU/source code combination => means we've found a inventory source item
        if ($this->hasBeenProcessed($sku, $sourceCode)) {
            return;
        }

        // query whether or not the inventory source is with the given code is avaiable
        if ($this->hasInventorySource($sourceCode)) {
            // create the MSI inventory source item
            $inventorySourceItem = $this->initializeInventorySourceItem($this->prepareAttributes());
            $this->persistInventorySourceItem($inventorySourceItem);

            // finaly, add the SKU + source code => source item ID mapping
            $this->addSkuSourceItemIdMapping($sku, $sourceCode);
        } else {
            // throw a new exception
            throw new \Exception(
                $this->appendExceptionSuffix(
                    sprintf('Can\'t load inventory source with code "%s"', $sourceCode)
                )
            );
        }
    }

    /**
     * Prepare the attributes of the entity that has to be persisted.
     *
     * @return array The prepared attributes
     */
    protected function prepareAttributes()
    {

        // load the MSI inventory source item values
        $sku = $this->getValue(ColumnKeys::SKU);
        $status = $this->getValue(ColumnKeys::STATUS);
        $sourceCode = $this->getValue(ColumnKeys::SOURCE_CODE);
        $quantity = $this->getValue(ColumnKeys::QUANTITY);

        // return the prepared MSI inventory source item
        return $this->initializeEntity(
            array(
                MemberNames::SKU         => $sku,
                MemberNames::STATUS      => $status,
                MemberNames::SOURCE_CODE => $sourceCode,
                MemberNames::QUANTITY    => $quantity
            )
        );
    }

    /**
     * Initialize the MSI inventory source item with the passed attributes and returns an instance.
     *
     * @param array $attr The inventory source item attributes
     *
     * @return array The initialized inventory source item
     * @throws \RuntimeException Is thrown, if the attributes can not be initialized
     */
    protected function initializeInventorySourceItem(array $attr)
    {
        return $attr;
    }

    /**
     * Queries whether or not the inventory source with the passed code is available.
     *
     * @param string $sourceCode The code of the inventory source to query for
     *
     * @return boolean TRUE if the inventory source with the passed code is available, FALSE if not
     */
    protected function hasInventorySource($sourceCode)
    {
        return $this->getSubject()->hasInventorySource($sourceCode);
    }

    /**
     * Add the passed SKU/source code => source item ID mapping.
     *
     * @param string $sku        The SKU
     * @param string $sourceCode The source code
     *
     * @return void
     */
    protected function addSkuSourceItemIdMapping($sku, $sourceCode)
    {
        $this->getSubject()->addSkuSourceItemIdMapping($sku, $sourceCode);
    }

    /**
     * Persist's the passed inventory source item data.
     *
     * @param array $inventorySourceItem The inventory source item data to persist
     *
     * @return void
     */
    protected function persistInventorySourceItem($inventorySourceItem)
    {
        $this->getMsiBunchProcessor()->persistInventorySourceItem($inventorySourceItem);
    }
}
