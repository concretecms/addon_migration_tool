<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\Content;

use PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\ValidatorTarget;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\ItemInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardItemValidator implements ValidatorInterface
{

    public function itemExists(ItemInterface $item, Batch $batch)
    {
        return is_object($item->getContentObject());
    }

    public function addMissingItemMessage(ItemInterface $item, ValidatorTarget $target)
    {
        $target->addMessage(
            new Message(t('%s content item %s cannot be found', $item->getDisplayName(), $item->getReference()))
        );
    }

}