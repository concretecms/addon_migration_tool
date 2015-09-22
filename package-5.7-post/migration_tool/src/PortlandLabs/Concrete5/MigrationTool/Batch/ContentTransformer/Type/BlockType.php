<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Type;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\TransformerInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class BlockType implements TransformerInterface
{

    public function getUntransformedEntityObjects()
    {
        return array();
    }

    public function getItem($entity)
    {
    }

    public function getMapper()
    {
        return new \PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\BlockType();
    }

    public function transform($entity, Item $item, TargetItem $targetItem)
    {

    }

}