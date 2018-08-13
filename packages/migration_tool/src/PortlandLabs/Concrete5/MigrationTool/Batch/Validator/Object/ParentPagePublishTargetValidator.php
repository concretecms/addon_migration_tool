<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Object;

use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageItem;
use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageTypeItem;
use Concrete\Core\Tree\Type\Topic;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectValidatorSubject;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\PageItemValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\PageTypeItemValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorSubjectInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

class ParentPagePublishTargetValidator implements ValidatorInterface
{

    public function validate(ValidatorSubjectInterface $subject)
    {
        /**
         * @var $subject BatchObjectValidatorSubject
         */
        $result = new ValidatorResult($subject);
        $control = $subject->getObject();

        $validator = new PageItemValidator();
        $item = new PageItem($control->getPath());
        if (!$validator->itemExists($item, $subject->getBatch())) {
            $validator->addMissingItemMessage($item, $result->getMessages());
        }

        return $result;
    }


}
