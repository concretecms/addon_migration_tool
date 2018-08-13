<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Object;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\Factory;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorSubjectInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardAttributeValidator implements ValidatorInterface
{
    public function validate(ValidatorSubjectInterface $subject)
    {
        $batch = $subject->getBatch();
        $value = $subject->getObject();
        $result = new ValidatorResult($subject);

        $items = $value->getInspector()->getMatchedItems($batch);
        foreach ($items as $item) {
            $validatorFactory = new Factory($item);
            $validator = $validatorFactory->getValidator();
            if (!$validator->itemExists($item, $batch)) {
                $validator->addMissingItemMessage($item, $result->getMessages());
            }
        }

        return $result;
    }
}
