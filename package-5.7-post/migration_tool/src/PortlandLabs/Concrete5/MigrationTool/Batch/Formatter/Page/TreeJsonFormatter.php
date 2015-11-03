<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Page;

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
        foreach($this->collection->getPages() as $page) {
            $messages = $this->validator->validate($page);
            $formatter = $messages->getFormatter();
            $node = new \stdClass;
            $node->title = $page->getName();
            $node->lazy = true;
            $node->nodetype = 'page';
            $node->extraClasses = 'migration-node-main';
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
