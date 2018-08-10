<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Pipeline\Stage;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use League\Pipeline\StageInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectCollectionValidatorSubject;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectValidatorSubject;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchValidatorResult;

class ValidateBatchRecordsStage implements StageInterface
{

    /**
     * @param $batchValidator BatchValidatorResult
     */
    public function __invoke($result)
    {
        $batch = $result->getBatch();
        $validatorMessages = $result->getMessages();
        foreach ($batch->getObjectCollections() as $collection) {
            if ($collection->hasRecords()) {
                $validator = $collection->getRecordValidator($batch);
                if (is_object($validator)) {
                    foreach($collection->getRecords() as $object) {
                        $subject = new BatchObjectValidatorSubject($batch, $object);
                        $messages = $validator->validate($subject);
                        foreach ($messages as $message) {
                            $validatorMessages->add($message);
                        }
                    }
                }
            }
        }
    }

}
