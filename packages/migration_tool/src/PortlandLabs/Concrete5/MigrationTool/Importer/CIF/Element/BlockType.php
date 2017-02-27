<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockTypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockType as CoreBlockType;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die('Access Denied.');

class BlockType implements ElementParserInterface
{
    protected $simplexml;

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $this->simplexml = $element;
        $collection = new BlockTypeObjectCollection();
        if ($this->simplexml->blocktypes->blocktype) {
            foreach ($this->simplexml->blocktypes->blocktype as $node) {
                $type = new CoreBlockType();
                $type->setHandle((string) $node['handle']);
                $type->setPackage((string) $node['package']);
                $collection->getTypes()->add($type);
                $type->setCollection($collection);
            }
        }

        return $collection;
    }
}
