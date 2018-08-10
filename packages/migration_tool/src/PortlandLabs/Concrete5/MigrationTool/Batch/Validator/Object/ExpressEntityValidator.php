<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Object;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectValidatorSubject;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorSubjectInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\UnknownAttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class ExpressEntityValidator implements ValidatorInterface
{


    public function validate(ValidatorSubjectInterface $subject)
    {
        /**
         * @var $subject BatchObjectValidatorSubject
         */
        $result = new ValidatorResult($subject);
        $entity = $subject->getObject();
        $keys = $entity->getAttributeKeys();
        if ($keys) {
            foreach($keys->getKeys() as $key) {
                if ($key instanceof UnknownAttributeKey) {
                    $result->getMessages()->add(
                        new Message(t('Attribute key is of an unknown type. It may not be imported properly.'))
                    );
                }

                $validator = $key->getRecordValidator($subject->getBatch());
                if (is_object($validator)) {
                    $r = $validator->validate($key);
                    $result->getMessages()->addMessages($r);
                }
            }

        }

        return $result;
    }

}
