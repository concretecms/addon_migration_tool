<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\StackBlock;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\StackObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Stack implements ElementParserInterface
{
    protected $blockImporter;

    public function __construct()
    {
        $this->blockImporter = \Core::make('migration/manager/import/cif_block');
    }

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $this->simplexml = $element;
        $collection = new StackObjectCollection();
        if ($element->stacks->stack) {
            foreach ($element->stacks->stack as $node) {
                $stack = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Stack();
                $stack->setName((string) $node['name']);
                $stack->setType((string) $node['type']);
                if ($node->area->blocks->block) {
                    $blocks = $node->area->blocks->block;
                } elseif ($node->area->block) { // 5.6
                    $blocks = $node->area->block;
                }
                if (isset($blocks)) {
                    $i = 0;
                    foreach ($blocks as $blockNode) {
                        if ($blockNode['type']) {
                            $block = new StackBlock();
                            $block->setType((string) $blockNode['type']);
                            $block->setName((string) $blockNode['name']);
                            $bFilename = (string) $blockNode['custom-template'];
                            if ($bFilename) {
                                $block->setCustomTemplate($bFilename);
                            }
                            $value = $this->blockImporter->driver('unmapped')->parse($blockNode);
                            if (isset($blockNode->style)) {
                                $styleSet = $this->styleSetImporter->import($blockNode->style);
                                $block->setStyleSet($styleSet);
                            }
                            $block->setBlockValue($value);
                            $block->setPosition($i);
                            $block->setStack($stack);
                            $stack->getBlocks()->add($block);
                            ++$i;
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
