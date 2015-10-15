<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\StackBlock;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\StackObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\TypeInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Stack implements TypeInterface
{

    protected $blockImporter;

    public function __construct()
    {
        $this->blockImporter = \Core::make('migration/manager/import/block');
    }

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $this->simplexml = $element;
        $collection = new StackObjectCollection();
        if ($element->stacks->stack) {
            foreach($element->stacks->stack as $node) {
                $stack = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Stack();
                $stack->setName((string) $node['name']);
                $stack->setType((string) $node['type']);
                if ($node->area->blocks->block) {
                    $blocks = $node->area->blocks->block;
                } else if ($node->area->block) { // 5.6
                    $blocks = $node->area->block;
                }
                if (isset($blocks)) {
                    $i = 0;
                    foreach($blocks as $blockNode) {
                        if ($blockNode['type']) {
                            $block = new StackBlock();
                            $block->setType((string) $node['type']);
                            $block->setName((string) $node['name']);
                            $value = $this->blockImporter->driver('unmapped')->parse($node);
                            $block->setBlockValue($value);
                            $block->setPosition($i);
                            $stack->getBlocks()->add($block);
                            $i++;
                        }
                    }
                }
                $collection->getStacks()->add($stack);
                $stack->setCollection($collection);
            }
        }
        return $collection;
    }

}
