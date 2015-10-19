<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageType;

use Concrete\Core\Backup\ContentImporter\ValueInspector\ValueInspector;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ItemValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\Factory;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class Validator extends AbstractValidator
{

    public function validate($type)
    {
        $collection = new MessageCollection();
        $target = $type->getPublishTarget();
        $validator = $target->getRecordValidator($this->getBatch());
        $messages = $validator->validate($target);
        if (is_object($messages) && count($messages)) {
            foreach($messages as $msg) {
                $collection->add($msg);
            }
        }

        return $collection;
    }
}