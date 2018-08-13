<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Object;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectValidatorSubject;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorSubjectInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\Factory;

defined('C5_EXECUTE') or die("Access Denied.");

class PageFeedValidator implements ValidatorInterface
{

    public function validate(ValidatorSubjectInterface $subject)
    {
        /**
         * @var $subject BatchObjectValidatorSubject
         */
        $batch = $subject->getBatch();
        $feed = $subject->getObject();
        $result = new ValidatorResult($subject);

        $items = $feed->getInspector()->getMatchedItems($batch);
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
