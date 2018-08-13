<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Pipeline\Stage;

use League\Pipeline\StageInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectCollectionValidatorSubject;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\Factory;

class ValidateReferencedContentItemsStage implements StageInterface
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

        $value = $block->getBlockValue();
        if (is_object($value)) {
            $inspector = $value->getInspector();
            $items = $inspector->getMatchedItems($batch);
            foreach ($items as $item) {
                $validatorFactory = new Factory($item);
                $validator = $validatorFactory->getValidator();
                if (!$validator->itemExists($item, $batch)) {
                    $validator->addMissingItemMessage($item, $validatorMessages);
                }
            }
        }

        return $result;
    }

}
