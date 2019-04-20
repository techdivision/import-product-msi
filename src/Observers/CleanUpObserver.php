<?php

/**
 * TechDivision\Import\Product\Msi\Observers\CleanUpObserver
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
use TechDivision\Import\Product\Msi\Services\MsiBunchProcessorInterface;

/**
 * Observer implementation that handles the process to import inventory source item bunches.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */
class CleanUpObserver extends AbstractMsiImportObserver
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

        // add the SKU/source code => source item ID mapping
        $this->addSkuSourceItemIdMapping($this->getValue(ColumnKeys::SKU), $this->getValue(ColumnKeys::SOURCE_CODE));

        // clean-up the repositories etc. to free memory
        $this->getMsiBunchProcessor()->cleanUp();
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
}
