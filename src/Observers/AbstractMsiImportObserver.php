<?php

/**
 * TechDivision\Import\Product\Observers\AbstractMsiImportObserver
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Msi\Observers;

use TechDivision\Import\Subjects\SubjectInterface;
use TechDivision\Import\Observers\AbstractObserver;

/**
 * Abstract observer that handles the process to import MSI inventory source item bunches.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-msi
 * @link      http://www.techdivision.com
 */
abstract class AbstractMsiImportObserver extends AbstractObserver implements MsiImportObserverInterface
{

    /**
     * Will be invoked by the action on the events the listener has been registered for.
     *
     * @param \TechDivision\Import\Subjects\SubjectInterface $subject The subject instance
     *
     * @return array The modified row
     * @see \TechDivision\Import\Observers\ObserverInterface::handle()
     */
    public function handle(SubjectInterface $subject)
    {

        // initialize the row
        $this->setSubject($subject);
        $this->setRow($subject->getRow());

        // process the functionality and return the row
        $this->process();

        // return the processed row
        return $this->getRow();
    }

    /**
     * Process the observer's business logic.
     *
     * @return void
     */
    abstract protected function process();

    /**
     * Queries whether or not the SKU/source code has already been processed.
     *
     * @param string $sku        The SKU to check been processed
     * @param string $sourceCode The source code to check been processed
     *
     * @return boolean TRUE if the SKU/source code has been processed, else FALSE
     */
    protected function hasSourceBeenProcessed($sku, $sourceCode)
    {
        return $this->getSubject()->hasSourceBeenProcessed($sku, $sourceCode);
    }
}
