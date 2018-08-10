<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;

class BatchValidator extends AbstractPipelineSupportingValidator
{

    /**
     * @param BatchValidatorSubject $subject
     * @return BatchValidatorResult|ValidatorResult
     */
    protected function getValidatorResult(ValidatorSubjectInterface $subject)
    {
        return new BatchValidatorResult($subject);
    }

    public function getFormatter(ValidatorResultInterface $result)
    {
        return new BatchMessageCollectionFormatter($result->getMessages());
    }

}
