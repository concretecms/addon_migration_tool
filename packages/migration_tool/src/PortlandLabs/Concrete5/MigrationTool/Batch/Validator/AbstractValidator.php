<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

use Concrete\Core\Foundation\Processor\Processor;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ItemValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class AbstractValidator implements ItemValidatorInterface
{

    protected $batch;

    public function __construct(Batch $batch)
    {
        $this->batch = $batch;
    }

    /**
     * @return Batch
     */
    public function getBatch()
    {
        return $this->batch;
    }

    /**
     * @param Batch $batch
     */
    public function setBatch($batch)
    {
        $this->batch = $batch;
    }


}