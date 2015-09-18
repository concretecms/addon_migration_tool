<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateAttributesTask implements TaskInterface
{

    public function execute(ActionInterface $action)
    {
        // Grab the target item for the page's page type.
        $subject = $action->getSubject();
        $attributeMapper = new Attribute();
        $targetItemList = new TargetItemList($subject->getBatch(), $attributeMapper);
        foreach($subject->getAttributes() as $attribute) {
            $item = new Item($attribute->getAttribute()->getHandle());
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if ($targetItem instanceof UnmappedTargetItem) {
                $action->getTarget()->addMessage(
                    new Message(t('Attribute <strong>%s</strong> does not exist.', $item->getIdentifier()), Message::E_WARNING)
                );
            }
        }
    }

    public function finish(ActionInterface $action)
    {

    }

}
