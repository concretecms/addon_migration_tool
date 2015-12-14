<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateThumbnailTypesRoutine implements RoutineInterface
{
    public function execute(Batch $batch)
    {
        $types = $batch->getObjectCollection('thumbnail_type');

        if (!$types) {
            return;
        }

        foreach ($types->getTypes() as $type) {
            if (!$type->getPublisherValidator()->skipItem()) {
                $t = new \Concrete\Core\File\Image\Thumbnail\Type\Type();
                $t->setName($type->getName());
                $t->setHandle($type->getHandle());
                $t->setWidth($type->getWidth());
                $t->setHeight($type->getHeight());
                if ($type->getIsRequired()) {
                    $t->requireType();
                }
                $t->save();
            }
        }
    }
}
