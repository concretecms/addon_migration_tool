<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageFeed;

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

    public function validate($feed)
    {
        $messages = new MessageCollection();
        $items = $feed->getInspector()->getMatchedItems();
        foreach($items as $item) {
            $validatorFactory = new Factory($item);
            $validator = $validatorFactory->getValidator();
            if (!$validator->itemExists($item, $this->getBatch())) {
                $validator->addMissingItemMessage($item, $messages);
            }
        }

        return $messages;
    }
}