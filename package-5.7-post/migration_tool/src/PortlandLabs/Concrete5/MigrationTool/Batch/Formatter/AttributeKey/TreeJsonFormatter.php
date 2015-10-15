<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AbstractTreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Validator;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKeyObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeJsonFormatter extends AbstractTreeJsonFormatter
{

    public function jsonSerialize()
    {
        $response = array();
        foreach($this->collection->getRecords() as $key) {
            $messages = $this->validator->validate($key);
            $formatter = $messages->getFormatter();
            $node = new \stdClass;
            $node->title = $key->getName();
            $node->skipped = $key->getPublisherValidator()->skipItem();
            $node->nodetype = 'attribute_key';
            $node->extraClasses = 'migration-node-main';
            $node->id = $key->getId();
            $node->handle = $key->getHandle();
            $node->type = $key->getType();
            $node->category = $key->getCategory();
            $node->statusClass = $formatter->getCollectionStatusIconClass();
            $this->addMessagesNode($node, $messages);
            $attributeFormatter = $key->getFormatter();
            $attributeNode = $attributeFormatter->getBatchTreeNodeJsonObject();
            if ($attributeNode) {
                $node->children[] = $attributeNode;
            }
            $response[] = $node;
        }
        return $response;
    }
}
