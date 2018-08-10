<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Object;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectValidatorSubject;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorSubjectInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\UnknownAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

class AttributeKeyValidator implements ValidatorInterface
{

    public function validate(ValidatorSubjectInterface $subject)
    {
        /**
         * @var $subject BatchObjectValidatorSubject
         */
        $result = new ValidatorResult($subject);
        $key = $subject->getObject();
        if ($key instanceof UnknownAttributeKey) {
            $result->getMessages()->add(
                new Message(t('Attribute key is of an unknown type. It may not be imported properly.'))
            );
        }

        $validator = $key->getRecordValidator($subject->getBatch());
        if (is_object($validator)) {
            $subject = new BatchObjectValidatorSubject($subject->getBatch(), $key);
            $r = $validator->validate($subject);
            $result->getMessages()->addMessages($r->getMessages());
        }

        return $result;
    }
}
