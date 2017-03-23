<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Attribute\Key\Category;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateAttributeSetsRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
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
                $logger->logPublished($set);
            } else {
                $logger->logSkipped($category);
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
