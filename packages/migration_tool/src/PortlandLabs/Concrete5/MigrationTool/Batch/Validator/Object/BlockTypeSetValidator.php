<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Object;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectValidatorSubject;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorSubjectInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class BlockTypeSetValidator implements ValidatorInterface
{
    public function validate(ValidatorSubjectInterface $subject)
    {
        /**
         * @var $subject BatchObjectValidatorSubject
         */
        $batch = $subject->getBatch();
        $set = $subject->getObject();
        $result = new ValidatorResult($subject);
        $collectionHandles = [];
        $collection = $batch->getObjectCollection('block_type');
        if ($collection) {
            foreach ($collection->getTypes() as $blockType) {
                $collectionHandles[] = $blockType->getHandle();
            }
        }
        $mapper = new \PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\BlockType();
        $targetItemList = new TargetItemList($subject->getBatch(), $mapper);
        foreach ($set->getTypes() as $type) {
            $item = new Item($type);
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if ($targetItem instanceof UnmappedTargetItem && !in_array($item->getIdentifier(), $collectionHandles)) {
                $result->getMessages()->add(
                    new Message(t('Block type <strong>%s</strong> does not exist.', $item->getIdentifier()), Message::E_WARNING)
                );
            }
        }

        return $result;
    }
}
