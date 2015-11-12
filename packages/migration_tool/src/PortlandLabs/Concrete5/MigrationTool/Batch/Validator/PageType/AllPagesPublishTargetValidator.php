<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageType;

use Concrete\Core\User\Group\Group;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ItemValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class AllPagesPublishTargetValidator extends AbstractValidator
{

    public function validate($entity)
    {
        $messages = new MessageCollection();
        return $messages;
    }


}