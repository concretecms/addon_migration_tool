<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Block;

use Concrete\Core\Foundation\Processor\Processor;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ItemValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidateProcessor;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class CollectionValidator extends ValidateProcessor
{

    public function getTarget($mixed)
    {
        return new CollectionValidatorTarget($this->getBatch(), $mixed);
    }

}