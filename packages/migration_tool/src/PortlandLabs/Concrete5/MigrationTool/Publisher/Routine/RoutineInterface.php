<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

interface RoutineInterface extends NormalizerInterface
{
    public function getPublisherRoutineActions(BatchInterface $batch);
}
