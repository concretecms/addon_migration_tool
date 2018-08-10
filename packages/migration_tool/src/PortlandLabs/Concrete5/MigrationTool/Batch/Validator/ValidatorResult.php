<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;

class ValidatorResult implements ValidatorResultInterface
{


    /**
     * @var ValidatorSubjectInterface
     */
    protected $subject;

    public function __construct(ValidatorSubjectInterface $subject)
    {
        $this->subject = $subject;
        $this->messages = new MessageCollection();
    }

    /**
     * @return ValidatorSubjectInterface
     */
    public function getSubject(): ValidatorSubjectInterface
    {
        return $this->subject;
    }

    /**
     * @return MessageCollection
     */
    public function getMessages()
    {
        return $this->messages;
    }


}
