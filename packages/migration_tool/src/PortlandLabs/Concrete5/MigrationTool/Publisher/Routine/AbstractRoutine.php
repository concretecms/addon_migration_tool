<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class AbstractRoutine implements RoutineInterface, RoutineActionInterface
{
    /**
     * @return RoutineActionInterface[]
     */
    public function getPublisherRoutineActions(BatchInterface $batch)
    {
        return array($this);
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof RoutineInterface;
    }

    public function normalize($object, $format = null, array $context = array())
    {
        return [];
    }

}
