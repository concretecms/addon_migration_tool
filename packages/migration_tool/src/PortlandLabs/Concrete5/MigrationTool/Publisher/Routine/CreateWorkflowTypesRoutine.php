<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Workflow\Type;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateWorkflowTypesRoutine implements RoutineInterface
{
    public function execute(Batch $batch)
    {
        $types = $batch->getObjectCollection('workflow_type');

        if (!$types) {
            return;
        }

        foreach ($types->getTypes() as $type) {
            if (!$type->getPublisherValidator()->skipItem()) {
                $pkg = null;
                if ($type->getPackage()) {
                    $pkg = \Package::getByHandle($type->getPackage());
                }
                Type::add($type->getHandle(), $type->getName(), $pkg);
            }
        }
    }
}
