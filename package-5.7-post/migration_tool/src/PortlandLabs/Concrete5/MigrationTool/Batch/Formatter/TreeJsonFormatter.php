<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter;

use PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\BatchValidator;
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
        $this->validator = new BatchValidator($this->batch);
        $this->formatter = $this->validator->getFormatter();
    }

    public function jsonSerialize()
    {
        $response = new \stdClass;
        $response->validator = new \stdClass;
        $response->validator->alertclass = $this->formatter->getAlertClass();
        $response->validator->message = $this->formatter->getCreateStatusMessage();
        $response->nodes = array();

        foreach($this->collection->getPages() as $page) {
            $messages = $this->validator->validatePage($page);
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
            $response->nodes[] = $node;
        }
        return $response;
    }
}
