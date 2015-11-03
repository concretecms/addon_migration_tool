<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Attribute\Key\Category;
use Concrete\Core\Attribute\Type;
use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Block\BlockType\Set;
use Concrete\Core\Page\Template;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateAttributeSetsRoutine implements RoutineInterface
{

    public function execute(Batch $batch)
    {
        $sets = $batch->getObjectCollection('attribute_set');
        foreach($sets->getSets() as $set) {
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
                foreach($attributes as $handle) {
                    $ak = $akc->getAttributeKeyByHandle($handle);
                    if (is_object($ak)) {
                        $setObject->addKey($ak);
                    }
                }
            }
        }
    }
}