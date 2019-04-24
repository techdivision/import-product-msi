<?php

/**
 * TechDivision\Import\Product\Msi\Subjects\AbstractMsiSubject
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

namespace TechDivision\Import\Product\Msi\Subjects;

use TechDivision\Import\Subjects\AbstractSubject;
use TechDivision\Import\Product\Msi\Utils\RegistryKeys;
use TechDivision\Import\Services\RegistryProcessorInterface;
use Doctrine\Common\Collections\Collection;
use League\Event\EmitterInterface;
use TechDivision\Import\Product\Msi\Services\MsiBunchProcessorInterface;
use TechDivision\Import\Utils\Generators\GeneratorInterface;

/**
 * The abstract subject implementation that provides basic MSI inventory source item
 * handling business logic.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */
abstract class AbstractMsiSubject extends AbstractSubject
{

    /**
     * The ID of the source item that has been created recently.
     *
     * @var string
     */
    protected $lastSourceItemId;

    /**
     * The mapping for the SKU/source code to the created source item IDs.
     *
     * @var array
     */
    protected $skuSourceItemIdMapping = array();

    /**
     * The available inventory sources.
     *
     * @var array
     */
    protected $inventorySources = array();

    /**
     * The MSI bunch processor instance.
     *
     * @var \TechDivision\Import\Product\Msi\Services\MsiBunchProcessorInterface
     */
    protected $msiBunchProcessor;

    /**
     * Initialize the subject instance.
     *
     * @param \TechDivision\Import\Services\RegistryProcessorInterface $registryProcessor          The registry processor instance
     * @param \TechDivision\Import\Utils\Generators\GeneratorInterface $coreConfigDataUidGenerator The UID generator for the core config data
     * @param \Doctrine\Common\Collections\Collection                  $systemLoggers              The array with the system loggers instances
     * @param \League\Event\EmitterInterface                           $emitter                    The event emitter instance
     */
    public function __construct(
        RegistryProcessorInterface $registryProcessor,
        GeneratorInterface $coreConfigDataUidGenerator,
        Collection $systemLoggers,
        EmitterInterface $emitter,
        MsiBunchProcessorInterface $msiBunchProcessor
    ) {

        // set the MSI bunch processor instance
        $this->msiBunchProcessor = $msiBunchProcessor;

        // pass the instances through to the parent instance
        parent::__construct($registryProcessor, $coreConfigDataUidGenerator, $systemLoggers, $emitter);
    }

    /**
     * Returns the MSI bunch processor instance.
     *
     * @return \TechDivision\Import\Product\Msi\Services\MsiBunchProcessorInterface The MSI bunch processor instance
     */
    protected function getMsiBunchProcessor()
    {
        return $this->msiBunchProcessor;
    }

    /**
     * Set's the ID of the source item that has been created recently.
     *
     * @param string $lastSourceItemId The entity ID
     *
     * @return void
     */
    public function setLastSourceItemId($lastSourceItemId)
    {
        $this->lastSourceItemId = $lastSourceItemId;
    }

    /**
     * Return's the ID of the source item that has been created recently.
     *
     * @return string The entity Id
     */
    public function getLastSourceItemId()
    {
        return $this->lastSourceItemId;
    }

    /**
     * Queries whether or not the SKU/source code has already been processed.
     *
     * @param string $sku        The SKU to check been processed
     * @param string $sourceCode The source code to check been processed
     *
     * @return boolean TRUE if the SKU/source code has been processed, else FALSE
     */
    public function hasBeenProcessed($sku, $sourceCode)
    {
        return isset($this->skuSourceItemIdMapping[$sku][$sourceCode]);
    }

    /**
     * Add the passed SKU/source code => source item ID mapping.
     *
     * @param string $sku        The SKU
     * @param string $sourceCode The source code
     *
     * @return void
     */
    public function addSkuSourceItemIdMapping($sku, $sourceCode)
    {
        $this->skuSourceItemIdMapping[$sku][$sourceCode] = $this->getLastSourceItemId();
    }

    /**
     * Queries whether or not the inventory source with the passed code is available.
     *
     * @param string $sourceCode The code of the inventory source to query for
     *
     * @return boolean TRUE if the inventory source with the passed code is available, FALSE if not
     */
    public function hasInventorySource($sourceCode)
    {
        return isset($this->inventorySources[$sourceCode]);
    }

    /**
     * Returns the inventory source with the passed code.
     *
     * @param string $sourceCode The code of the inventory source to return
     *
     * @return array The inventory source for the passed code
     * @throws \Exception Is thrown, if the inventory source with the passed code is NOT available
     */
    public function getInventorySourceBySourceCode($sourceCode)
    {

        // query whether or not the inventory source is available
        if (isset($this->inventorySources[$sourceCode])) {
            return $this->inventorySources[$sourceCode];
        }

        // throw a new exception
        throw new \Exception(
            $this->appendExceptionSuffix(
                sprintf('Can\'t load inventory source with code "%s"', $sourceCode)
            )
        );
    }

    /**
     * Intializes the previously loaded global data for exactly one bunch.
     *
     * @param string $serial The serial of the actual import
     *
     * @return void
     */
    public function setUp($serial)
    {

        // invoke the parent method
        parent::setUp($serial);

        // load the available inventory sources
        $this->inventorySources = $this->getMsiBunchProcessor()->loadInventorySources();
    }

    /**
     * Clean up the global data after importing the bunch.
     *
     * @param string $serial The serial of the actual import
     *
     * @return void
     */
    public function tearDown($serial)
    {

        // load the registry processor
        $registryProcessor = $this->getRegistryProcessor();

        // update the status
        $registryProcessor->mergeAttributesRecursive(
            $serial,
            array(
                RegistryKeys::SKU_SOURCE_ITEM_ID_MAPPING => $this->skuSourceItemIdMapping
            )
        );

        // invoke the parent method
        parent::tearDown($serial);
    }
}
