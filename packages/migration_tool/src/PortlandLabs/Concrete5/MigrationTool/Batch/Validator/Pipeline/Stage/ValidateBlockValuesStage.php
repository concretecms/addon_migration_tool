<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Pipeline\Stage;

use League\Pipeline\StageInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectCollectionValidatorSubject;

class ValidateBlockValuesStage implements StageInterface
{

    public function __invoke($result)
    {
        $subject = $result->getSubject();
        $batch = $subject->getBatch();
        $block = $subject->getObject();
        $validatorMessages = $result->getMessages();

        $value = $block->getBlockValue();
        if ($value) {
            $validator = $value->getRecordValidator($batch);
            if (is_object($validator)) {
                $r = $validator->validate($value);
                if (is_object($r)) {
                    foreach ($r as $message) {
                        $validatorMessages->addMessage($message);
                    }
                }
            }
        }

        return $result;
    }

}
