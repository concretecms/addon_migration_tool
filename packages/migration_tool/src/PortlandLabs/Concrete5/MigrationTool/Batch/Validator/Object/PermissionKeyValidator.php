<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Object\PermissionKey;

use Concrete\Core\Permission\Category;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectValidatorSubject;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorSubjectInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Validator implements ValidatorInterface
{
    public function validate(ValidatorSubjectInterface $subject)
    {
        /**
         * @var $subject BatchObjectValidatorSubject
         */
        $batch = $subject->getBatch();
        $key = $subject->getObject();
        $result = new ValidatorResult($subject);

        // Validate the category
        if (!$this->categoryExists($key->getCategory(), $batch)) {
            $result->getMessages()->add(
                new Message(t('Permission category %s does not exist in the site or in the current content batch', $key->getCategory()))
            );
        }
        foreach ($key->getAccessEntities() as $entity) {
            $entityValidator = $entity->getRecordValidator($batch);
            if ($entityValidator) {
                $entitySubject = new BatchObjectValidatorSubject($batch, $entity);
                $entityValidatorResult = $entityValidator->validate($entitySubject);
                foreach ($entityValidatorResult->getMesages() as $message) {
                    $result->getMessages()->add($message);
                }
            }
        }

        return $result;
    }

    public function categoryExists($handle, $batch)
    {
        $category = Category::getByHandle($handle);
        if (is_object($category)) {
            return true;
        }

        $categories = $batch->getObjectCollection('permission_key_category');
        foreach ($categories->getCategories() as $c) {
            if ($c->getHandle() == $handle) {
                return true;
            }
        }
    }
}
