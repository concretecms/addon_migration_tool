<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ExpressEntity;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AbstractTreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Validator;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Entity;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeJsonFormatter extends AbstractTreeJsonFormatter
{
    public function jsonSerialize()
    {
        $response = array();
        /**
         * @var $entity Entity
         */
        foreach ($this->collection->getRecords() as $entity) {
            $messages = $this->validator->validate($entity);
            $formatter = $messages->getFormatter();
            $node = new \stdClass();
            $node->title = $entity->getName();
            $node->exists = $entity->getPublisherValidator()->skipItem();
            $node->nodetype = 'express_entity';
            $node->extraClasses = 'migration-node-main';
            $node->id = $entity->getId();
            $node->handle = $entity->getHandle();
            $node->statusClass = $formatter->getCollectionStatusIconClass();
            $this->addMessagesNode($node, $messages);

            $associationsHolderNode = new \stdClass();
            $associationsHolderNode->icon = 'fa fa-cubes';
            $associationsHolderNode->title = t('Associations');
            $associationsHolderNode->children = array();

            $formsHolderNode = new \stdClass();
            $formsHolderNode->icon = 'fa fa-file';
            $formsHolderNode->title = t('Forms');
            $formsHolderNode->children = array();


            $node->children[] = $associationsHolderNode;
            $node->children[] = $formsHolderNode;


            $response[] = $node;
        }

        return $response;
    }
}
