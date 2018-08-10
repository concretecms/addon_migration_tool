<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;

class BatchObjectValidatorSubject extends BatchValidatorSubject
{

    /**
     * @var $mixed
     */
    protected $object;

    /**
     * BatchValidatorSubject constructor.
     * @param BatchInterface $batch
     */
    public function __construct(BatchInterface $batch, $object)
    {
        parent::__construct($batch);
        $this->object = $object;
    }

    /**
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }


}
