<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockTypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockType as CoreBlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplateObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\TypeInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class BlockType implements TypeInterface
{

    protected $simplexml;

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $this->simplexml = $element;
        $collection = new BlockTypeObjectCollection();
        if ($this->simplexml->blocktypes->blocktype) {
            foreach($this->simplexml->blocktypes->blocktype as $node) {
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
