<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BlockTypeSet;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ItemValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\UnknownAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class Validator implements ItemValidatorInterface
{

    public function validate(Batch $batch, $set)
    {
        $messages = new MessageCollection();
        $mapper = new \PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\BlockType();
        $targetItemList = new TargetItemList($batch, $mapper);
        foreach($set->getTypes() as $type) {
            $item = new Item($type);
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if ($targetItem instanceof UnmappedTargetItem) {
                $messages->add(
                    new Message(t('Block type <strong>%s</strong> does not exist.', $item->getIdentifier()))
                );
            }
        }
        return $messages;
    }
}