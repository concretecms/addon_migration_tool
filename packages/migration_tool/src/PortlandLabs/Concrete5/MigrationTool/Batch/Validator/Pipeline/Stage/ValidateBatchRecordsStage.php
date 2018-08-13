<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Pipeline\Stage;

use League\Pipeline\StageInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectCollectionValidatorSubject;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectValidatorSubject;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResultInterface;

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
                        $validatorResult = $validator->validate($subject);
                        /**
                         * @var $validatorResult ValidatorResultInterface
                         */
                        foreach ($validatorResult->getMessages() as $message) {
                            $validatorMessages->add($message);
                        }
                    }
                }
            }
        }
        return $result;
    }

}
