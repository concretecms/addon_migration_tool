<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Object\Validator\Objecvt;

use Concrete\Core\User\Group\Group;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorSubjectInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class GroupAccessEntityValidator implements ValidatorInterface
{
    public function validate(ValidatorSubjectInterface $subject)
    {

        $batch = $subject->getBatch();
        $entity = $subject->getObject();
        $result = new ValidatorResult($subject);

        if (!$this->groupExists($entity->getGroupName(), $batch)) {
            $result->getMessages()->add(
                new Message(t('Group %s does not exist in the site or in the current content batch', $entity->getGroupName()))
            );
        }

        return $result;
    }

    public function groupExists($name, $batch)
    {
        $g = Group::getByName($name);
        if (is_object($g)) {
            return true;
        }

        return false;
    }
}
