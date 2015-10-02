<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\Validator;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeJsonFormatter implements \JsonSerializable
{

    public function __construct(PageObjectCollection $collection)
    {
        $em = \ORM::entityManager('migraton_tool');
        $r = $em->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
        $this->collection = $collection;
        $this->batch = $r->findFromCollection($collection);
        $this->validator = \Core::make('migration/batch/page/validator');
    }

    public function jsonSerialize()
    {
        $response = array();
        foreach($this->collection->getPages() as $page) {
            $messages = $this->validator->validate($this->batch, $page);
            $formatter = $messages->getFormatter();
            $node = new \stdClass;
            $node->title = $page->getName();
            $node->lazy = true;
            $node->type = 'page';
            $node->extraClasses = 'migration-page';
            $node->id = $page->getId();
            $node->pagePath = '<a href="#" data-editable-property="path" data-type="text" data-pk="' . $page->getID() . '" data-title="' . t('Page Path') . '">' . $page->getBatchPath() . '</a>';
            $node->pageType = $page->getType();
            $node->pageTemplate = $page->getTemplate();
            $node->statusClass = $formatter->getCollectionStatusIconClass();
            $response[] = $node;
        }
        return $response;
    }
}
