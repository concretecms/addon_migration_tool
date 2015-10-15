<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Stack;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AbstractTreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Validator;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeJsonFormatter extends AbstractTreeJsonFormatter
{

    public function jsonSerialize()
    {
        $response = array();
        foreach($this->collection->getStacks() as $stack) {
            $messages = $this->validator->validate($stack);
            $formatter = $messages->getFormatter();
            $node = new \stdClass;
            $node->title = $stack->getName();
            $node->stackType = $stack->getType();
            $node->nodetype = 'stack';
            $node->exists = $stack->getPublisherValidator()->skipItem();
            $node->extraClasses = 'migration-node-main';
            $node->id = $stack->getId();
            $node->statusClass = $formatter->getCollectionStatusIconClass();
            $this->addMessagesNode($node, $messages);
            $response[] = $node;
        }
        return $response;
    }
}
