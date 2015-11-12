<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

interface TransformerInterface
{

    public function getUntransformedEntityObjects();
    public function getItem($entity);
    public function getMapper();
    public function transform($entity, ItemInterface $item, TargetItem $targetItem, Batch $batch);

}