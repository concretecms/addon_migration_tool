<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Pipeline\Stage;

use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\StackItem;
use League\Pipeline\StageInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectCollectionValidatorSubject;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\StackItemValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StackDisplayBlockValue;

class ValidateReferencedStacksStage implements StageInterface
{

    /**
     * @param $result ValidatorResult
     */
    public function __invoke($result)
    {
        $subject = $result->getSubject();
        $batch = $subject->getBatch();
        $block = $subject->getObject();
        $validatorMessages = $result->getMessages();

        if ($block->getType() == 'core_stack_display') {
            $value = $block->getBlockValue();
            if ($value instanceof StackDisplayBlockValue) {
                $stack = $value->getStackPath();
                $validator = new StackItemValidator();
                $item = new StackItem($stack);
                if (!$validator->itemExists($item, $batch)) {
                    $validator->addMissingItemMessage($item, $validatorMessages);
                }
            }
        }

        return $result;
    }

}
