<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PermissionKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ItemValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class AccessEntityValidator implements ItemValidatorInterface
{

    public function validate(Batch $batch, $entity)
    {
        return false;
    }

}