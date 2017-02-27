<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

interface TransformableEntityMapperInterface
{
    function getTransformableEntityObjects(BatchInterface $batch);
}
