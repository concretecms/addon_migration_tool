<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Object;

use Concrete\Core\User\UserInfo;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorSubjectInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class UserAccessEntityValidator implements ValidatorInterface
{
    public function validate(ValidatorSubjectInterface $subject)
    {
        $batch = $subject->getBatch();
        $entity = $subject->getObject();
        $result = new ValidatorResult($subject);
        if (!$this->userExists($entity->getUserName(), $batch)) {
            $result->getMessages()->add(
                new Message(t('User %s does not exist in the site or in the current content batch', $entity->getUserName()))
            );
        }

        return $result;
    }

    public function userExists($username, $batch)
    {
        $ui = UserInfo::getByUserName($username);
        if (is_object($ui)) {
            return true;
        }

        return false;
    }
}
