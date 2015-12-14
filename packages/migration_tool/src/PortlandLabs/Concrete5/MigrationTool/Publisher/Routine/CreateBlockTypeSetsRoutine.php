<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Block\BlockType\Set;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateBlockTypeSetsRoutine implements RoutineInterface
{
    public function execute(Batch $batch)
    {
        $sets = $batch->getObjectCollection('block_type_set');

        if (!$sets) {
            return;
        }

        foreach ($sets->getSets() as $set) {
            if (!$set->getPublisherValidator()->skipItem()) {
                $pkg = null;
                if ($set->getPackage()) {
                    $pkg = \Package::getByHandle($set->getPackage());
                }
                $set = Set::add($set->getHandle(), $set->getName(), $pkg);
                $types = $set->getTypes();
                foreach ($types as $handle) {
                    $bt = BlockType::getByHandle($handle);
                    if (is_object($bt)) {
                        $set->addBlockType($bt);
                    }
                }
            }
        }
    }
}
