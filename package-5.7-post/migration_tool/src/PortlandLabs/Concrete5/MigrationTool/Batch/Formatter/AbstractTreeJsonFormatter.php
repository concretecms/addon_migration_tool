<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Validator;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class AbstractTreeJsonFormatter implements \JsonSerializable
{

    public function __construct(ObjectCollection $collection)
    {
        $em = \ORM::entityManager('migration_tool');
        $r = $em->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
        $this->collection = $collection;
        $this->batch = $r->findFromCollection($collection);
        $this->validator = $collection->getRecordValidator();
    }

    protected function addMessagesNode(\stdClass $node, MessageCollection $messages)
    {
        if ($messages->count()) {
            $messageHolderNode = new \stdClass;
            $messageHolderNode->iconclass = $node->statusClass;
            $messageHolderNode->title = t('Errors');
            $messageHolderNode->children = array();
            foreach($messages as $m) {
                $messageNode = new \stdClass;
                $messageNode->iconclass = $m->getFormatter()->getIconClass();
                $messageNode->title = $m->getFormatter()->output();
                $messageHolderNode->children[] = $messageNode;
            }
            $node->children[] = $messageHolderNode;
        }
    }

}
