<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;

class BatchValidatorSubject implements ValidatorSubjectInterface
{

    /**
     * @var BatchInterface
     */
    protected $batch;

    /**
     * BatchValidatorSubject constructor.
     * @param BatchInterface $batch
     */
    public function __construct(BatchInterface $batch)
    {
        $this->batch = $batch;
    }

    /**
     * @return BatchInterface
     */
    public function getBatch(): BatchInterface
    {
        return $this->batch;
    }



}
