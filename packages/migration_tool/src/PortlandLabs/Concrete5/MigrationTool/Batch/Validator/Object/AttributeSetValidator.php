<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Object;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectValidatorSubject;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorSubjectInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class AttributeSetValidator implements ValidatorInterface
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
        $collection = $batch->getObjectCollection('attribute_key');
        if ($collection) {
            foreach ($collection->getKeys() as $attributeKey) {
                $collectionHandles[] = $attributeKey->getHandle();
            }
        }

        $manager = \Core::make('migration/manager/import/attribute/category');
        $mapper = $manager->getAttributeCategoryMapper($set->getCategory());
        $targetItemList = new TargetItemList($subject->getBatch(), $mapper);
        foreach ($set->getAttributes() as $attribute) {
            $item = new Item($attribute);
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if ($targetItem instanceof UnmappedTargetItem && !in_array($item->getIdentifier(), $collectionHandles)) {
                $result->getMessages()->add(
                    new Message(t('Attribute <strong>%s</strong> does not exist.', $item->getIdentifier()), Message::E_WARNING)
                );
            }
        }

        return $result;
    }
}
