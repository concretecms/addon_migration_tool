<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Permission\Key\Key;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreatePermissionsRoutine implements RoutineInterface
{
    public function execute(Batch $batch)
    {
        $keys = $batch->getObjectCollection('permission_key');

        if (!$keys) {
            return;
        }

        foreach ($keys->getKeys() as $key) {
            if (!$key->getPublisherValidator()->skipItem()) {
                $pkg = null;
                if ($key->getPackage()) {
                    $pkg = \Package::getByHandle($key->getPackage());
                }
                $p = Key::add($key->getCategory(), $key->getHandle(), $key->getName(), $key->getDescription(), $key->getCanTriggerWorkflow(), $key->getHasCustomClass(),  $pkg);
                foreach ($key->getAccessEntities() as $entity) {
                    $publisher = $entity->getPublisher();
                    $publisher->publish($p, $entity);
                }
            }
        }
    }
}
