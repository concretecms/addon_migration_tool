<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;

class BatchValidatorResult extends ValidatorResult
{

    public function getBatch()
    {
        return $this->subject->getBatch();
    }

    public function getFormatter(ValidatorResultInterface $result)
    {
        return new BatchMessageCollectionFormatter($result->getMessages());
    }

}
