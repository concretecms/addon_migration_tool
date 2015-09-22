<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Type;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\TransformerInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class Attribute implements TransformerInterface
{

    public function getUntransformedEntityObjects()
    {
        $em = \ORM::entityManager('migration_tool');
        $r = $em->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\ImportedAttributeValue');
        return $r->findAll();
    }

    public function getItem($attribute_value)
    {
        $handle = $attribute_value->getAttribute()->getHandle();
        $item = new Item($handle);
        return $item;
    }

    public function getMapper()
    {
        return new \PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Attribute();
    }

    public function transform($entity, Item $item, TargetItem $targetItem)
    {

    }



}