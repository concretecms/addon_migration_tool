<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Object;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ItemValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorSubjectInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StandardBlockValue;

defined('C5_EXECUTE') or die("Access Denied.");

class ImageSliderBlockValidator implements ValidatorInterface
{

    public function validate(ValidatorSubjectInterface $subject)
    {
        $value = $subject->getObject();
        $result = new ValidatorResult($subject);

        $record = $value->getRecords()[0];
        if ($record) {
            $data = $record->getData();
            if (isset($data['fsID']) && $data['fsID'] > 0) {
                $pageName = 'Unknown Page';

                if ($area = $value->getBlock()->getArea()) {
                    $pageName = $area->getPage()->getName();
                }

                $result->getMessages()->add(new Message(t('Slideshow block on page "%s" uses a file set for display. This will not migrate properly.', $pageName)));
            }
        }

        return $result;
    }
}
