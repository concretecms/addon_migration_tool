<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Object;

use Concrete\Core\Tree\Type\Topic;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectValidatorSubject;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorSubjectInterface;

class TopicsAttributeKeyValidator implements ValidatorInterface
{

    public function validate(ValidatorSubjectInterface $subject)
    {
        /**
         * @var $subject BatchObjectValidatorSubject
         */
        $result = new ValidatorResult($subject);
        $key = $subject->getObject();
        if (!$this->topicTreeExists($key->getTreeName(), $subject->getBatch())) {
            $result->getMessages()->add(
                new Message(t('Topic tree %s does not exist in the site or in the current content batch', $key->getTreeName()))
            );
        }

        return $result;
    }


    public function topicTreeExists($name, $batch)
    {
        $tree = Topic::getByName($name);
        if (is_object($tree)) {
            return true;
        }

        $r = \Package::getByHandle('migration_tool')->getEntityManager()->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Tree');
        $tree = $r->findOneByName($name);
        if (is_object($tree)) {
            return true;
        }

        return false;
    }
}
