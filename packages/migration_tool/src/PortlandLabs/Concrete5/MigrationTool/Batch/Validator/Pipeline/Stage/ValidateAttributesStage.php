<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Pipeline\Stage;

use League\Pipeline\StageInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectValidatorSubject;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\ImportedAttributeValue;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateAttributesStage implements StageInterface
{

    /**
     * @param $result ValidatorResult
     */
    public function __invoke($result)
    {
        /**
         *
         */
        $subject = $result->getSubject();
        $object = $subject->getObject();
        $batch = $subject->getBatch();
        $mappers  = \Core::make('migration/manager/mapping');
        $attributeMapper = $mappers->driver($object->getAttributeValidatorDriver());
        $targetItemList = $mappers->createTargetItemList($batch, $attributeMapper);
        foreach ($object->getAttributes() as $attribute) {
            $item = new Item($attribute->getAttribute()->getHandle());
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if (!($targetItem instanceof IgnoredTargetItem)) {
                if ($targetItem instanceof UnmappedTargetItem) {
                    $result->getMessages()->addMessage(
                        new Message(t('Attribute <strong>%s</strong> does not exist.', $item->getIdentifier()), Message::E_WARNING)
                    );
                }

                $value = $attribute->getAttribute()->getAttributeValue();
                if ($value instanceof ImportedAttributeValue) {
                    $result->getMessages()->addMessage(
                        new Message(t('Attribute <strong>%s</strong> could not be mapped to a known attribute type. It may not be fully imported.', $item->getIdentifier()), Message::E_WARNING)
                    );
                }

                $validator = $value->getRecordValidator($batch);
                if (is_object($validator)) {
                    $valueSubject = new BatchObjectValidatorSubject($batch, $value);
                    $validatorResult = $validator->validate($valueSubject);
                    foreach ($validatorResult->getMessages() as $message) {
                        $result->getMessages()->add($message);
                    }
                }
            }
        }
        return $result;
    }

}
