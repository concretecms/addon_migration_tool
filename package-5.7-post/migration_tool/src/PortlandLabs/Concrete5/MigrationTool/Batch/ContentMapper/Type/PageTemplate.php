<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class PageTemplate implements MapperInterface
{

    public function getMappedItemPluralName()
    {
        return t('Page Templates');
    }

    public function getHandle()
    {
        return 'page_template';
    }

    public function getItems(Batch $batch)
    {
        $templates = array();
        foreach($batch->getPages() as $page) {
            if (!in_array($page->getTemplate(), $templates)) {
                $templates[] = $page->getTemplate();
            }
        }
        $items = array();
        foreach($templates as $template) {
            $item = new Item();
            $item->setIdentifier($template);
            $items[] = $item;
        }
        return $items;
    }

    public function getTargetItems()
    {
        return array();
    }



}