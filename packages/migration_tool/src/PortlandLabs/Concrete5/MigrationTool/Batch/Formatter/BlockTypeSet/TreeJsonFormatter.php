<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\BlockTypeSet;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AbstractTreeJsonFormatter;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeJsonFormatter extends AbstractTreeJsonFormatter
{
    public function jsonSerialize()
    {
        $response = array();
        foreach ($this->collection->getSets() as $set) {
            $messages = $this->getValidationMessages($set);
            $formatter = $messages->getFormatter();
            $node = new \stdClass();
            $node->title = $set->getName();
            $node->handle = $set->getHandle();
            $node->blockTypes = implode(', ', $set->getTypes());
            $node->nodetype = 'block_type_set';
            $node->extraClasses = 'migration-node-main';
            $node->id = $set->getId();
            $node->statusClass = $formatter->getCollectionStatusIconClass();
            $this->addMessagesNode($node, $messages);
            $response[] = $node;
        }

        return $response;
    }
}
