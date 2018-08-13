<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Pipeline\Stage;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\ImportedAttributeValue;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateExpressAttributesStage extends ValidateAttributesStage
{

    public function __invoke($result)
    {
        $subject = $result->getSubject();
        $batch = $subject->getBatch();
        $entity = $subject->getObject();

        $attributeMapper = $this->mappers->driver($entity->getAttributeValidatorDriver());
        $targetItemList = $this->mappers->createTargetItemList($batch, $attributeMapper);
        foreach ($entity->getAttributes() as $attribute) {
            $item = new Item($entity->getEntity() . '|' . $attribute->getAttribute()->getHandle());
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if (!($targetItem instanceof IgnoredTargetItem)) {
                if ($targetItem instanceof UnmappedTargetItem) {
                    $result->getMessages()->addMessage(
                        new Message(t('Attribute <strong>%s</strong> for entity <strong>%s</strong> does not exist.', $attribute->getAttribute()->getHandle(), $entity->getEntity()), Message::E_WARNING)
                    );
                }

                $value = $attribute->getAttribute()->getAttributeValue();
                if ($value instanceof ImportedAttributeValue) {
                    $result->getMessages()->addMessage(
                        new Message(t('Attribute <strong>%s</strong> for entity <strong>%s</strong> could not be mapped to a known attribute type. It may not be fully imported.', $attribute->getAttribute()->getHandle(), $entity->getEntity()), Message::E_WARNING)
                    );
                }

                $validator = $value->getRecordValidator($batch);
                if (is_object($validator)) {
                    $r = $validator->validate($value);
                    if (is_object($r)) {
                        foreach ($r as $message) {
                            $result->getMessages()->addMessage($message);
                        }
                    }
                }
            }
        }

        return $result;
    }

}
