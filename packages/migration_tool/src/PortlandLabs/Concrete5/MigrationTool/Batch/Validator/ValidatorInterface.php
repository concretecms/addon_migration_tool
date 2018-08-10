<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;

interface ValidatorInterface
{


    /**
     * @param ValidatorSubjectInterface $subject
     * @return ValidatorResultInterface
     */
    public function validate(ValidatorSubjectInterface $subject);

}
