<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageType;

use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageItem;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ItemValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\PageItemValidator;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class ParentPagePublishTargetValidator extends AbstractValidator
{

    public function validate($entity)
    {
        $messages = new MessageCollection();
        $validator = new PageItemValidator();
        $item = new PageItem($entity->getPath());
        if (!$validator->itemExists($item, $this->getBatch())) {
            $validator->addMissingItemMessage($item, $messages);
        }

        return $messages;
    }


}