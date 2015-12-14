<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Attribute\Key\Category;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateAttributeSetsRoutine implements RoutineInterface
{
    public function execute(Batch $batch)
    {
        $sets = $batch->getObjectCollection('attribute_set');

        if (!$sets) {
            return;
        }

        foreach ($sets->getSets() as $set) {
            $akc = Category::getByHandle($set->getCategory());
            if (!$set->getPublisherValidator()->skipItem()) {
                $pkg = null;
                if ($set->getPackage()) {
                    $pkg = \Package::getByHandle($set->getPackage());
                }
                $setObject = $akc->addSet($set->getHandle(), $set->getName(), $pkg, intval($set->getIsLocked()));
            } else {
                $setObject = \Concrete\Core\Attribute\Set::getByHandle($set->getHandle());
            }

            if (is_object($setObject)) {
                $attributes = $set->getAttributes();
                foreach ($attributes as $handle) {
                    $ak = $akc->getAttributeKeyByHandle($handle);
                    if (is_object($ak)) {
                        $setObject->addKey($ak);
                    }
                }
            }
        }
    }
}
