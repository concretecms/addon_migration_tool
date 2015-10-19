<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PageType;

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
        foreach($this->collection->getTypes() as $type) {
            $messages = $this->validator->validate($type);
            $formatter = $messages->getFormatter();
            $node = new \stdClass;
            $node->title = $type->getName();
            $node->handle = $type->getHandle();
            $node->nodetype = 'page_type';
            $node->exists = $type->getPublisherValidator()->skipItem();
            $node->extraClasses = 'migration-node-main';
            $node->id = $type->getId();
            $node->statusClass = $formatter->getCollectionStatusIconClass();
            $this->addMessagesNode($node, $messages);
            $targetFormatter = $type->getPublishTarget()->getFormatter();
            $targetNode = $targetFormatter->getBatchTreeNodeJsonObject();
            if ($targetNode) {
                $node->children[] = $targetNode;
            }
            foreach($type->getLayoutSets() as $set) {
                $setNode = new \stdClass;
                $setNode->title = $set->getName();
                foreach($set->getControls() as $control) {
                    $controlNode = new \stdClass;
                    $controlNode->title = $control->getLabel();
                    $setNode->children[] = $controlNode;
                }
                $node->children[] = $setNode;
            }
            $response[] = $node;
        }
        return $response;
    }
}
