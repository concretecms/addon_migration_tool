<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Object;

use Concrete\Core\Tree\Type\Topic;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectValidatorSubject;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorSubjectInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

class BlockComposerFormLayoutSetControlValidator implements ValidatorInterface
{

    public function validate(ValidatorSubjectInterface $subject)
    {
        /**
         * @var $subject BatchObjectValidatorSubject
         */
        $result = new ValidatorResult($subject);
        $control = $subject->getObject();

        $attributeMapper = new BlockType();
        $targetItemList = new TargetItemList($subject->getBatch(), $attributeMapper);
        $item = new Item($control->getItemIdentifier());
        $targetItem = $targetItemList->getSelectedTargetItem($item);
        if ($targetItem instanceof UnmappedTargetItem) {
            $result->getMessages()->add(
                new Message(t('Block type <strong>%s</strong> does not exist in the current batch or in the site.', $item->getIdentifier()))
            );
        }

        return $result;
    }


}
