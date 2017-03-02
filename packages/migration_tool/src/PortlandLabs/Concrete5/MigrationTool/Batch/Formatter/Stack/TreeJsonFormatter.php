<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Stack;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AbstractTreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Validator;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeJsonFormatter extends AbstractTreeJsonFormatter
{
    public function jsonSerialize()
    {
        $response = array();
        foreach ($this->collection->getStacks() as $stack) {
            $messages = $this->validator->validate($stack);
            $stackFormatter = $stack->getStackFormatter();
            $formatter = $messages->getFormatter();
            $node = new \stdClass();
            $node->title = $stack->getName();
            $node->stackType = $stack->getType();
            $node->pagePath = $stack->getPath();
            $node->icon = $stackFormatter->getIconClass();
            $node->nodetype = 'stack';
            $node->exists = $stack->getPublisherValidator()->skipItem();
            $node->extraClasses = 'migration-node-main';
            $node->id = $stack->getId();
            $node->statusClass = $formatter->getCollectionStatusIconClass();
            $this->addMessagesNode($node, $messages);
            $node->children = [];

            if (count($stack->getBlocks()) > 0) {
                $holderNode = new \stdClass();
                $holderNode->icon = 'fa fa-cubes';
                $holderNode->title = t('Blocks');
                foreach ($stack->getBlocks() as $block) {
                    $value = $block->getBlockValue();
                    if (is_object($value)) {
                        $blockFormatter = $value->getFormatter();
                        $blockNode = $blockFormatter->getBatchTreeNodeJsonObject();
                        if ($styleSet = $block->getStyleSet()) {
                            $styleSetFormatter = new StyleSetTreeJsonFormatter($styleSet);
                            $blockNode->children[] = $styleSetFormatter->getBatchTreeNodeJsonObject();
                        }
                        $holderNode->children[] = $blockNode;
                    }
                }
                $node->children[] = $holderNode;
            }

            $response[] = $node;

        }

        return $response;
    }
}
