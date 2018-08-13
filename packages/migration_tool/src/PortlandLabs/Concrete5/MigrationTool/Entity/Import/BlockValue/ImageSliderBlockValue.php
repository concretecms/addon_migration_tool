<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Object\ImageSliderBlockValidator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="MigrationImportImageSliderBlockValues")
 * @ORM\Entity
 */
class ImageSliderBlockValue extends StandardBlockValue
{

    public function getRecordValidator(BatchInterface $batch)
    {
        return new ImageSliderBlockValidator();
    }

    public function getPublisher()
    {
        $manager = \Core::make('migration/manager/publisher/block');
        return $manager->driver('image_slider');
    }

}
