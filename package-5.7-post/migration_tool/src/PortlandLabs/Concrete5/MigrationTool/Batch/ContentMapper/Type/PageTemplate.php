<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use Concrete\Core\Page\Template;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
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
            if ($page->getTemplate() && !in_array($page->getTemplate(), $templates)) {
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

    public function getMatchedTargetItem(ItemInterface $item)
    {
        $template = Template::getByHandle($item->getIdentifier());
        if (is_object($template)) {
            $targetItem = new TargetItem($this);
            $targetItem->setItemId($template->getPageTemplateID());
            $targetItem->setItemName($template->getPageTemplateName());
            return $targetItem;
        }
    }


    public function getTargetItems(Batch $batch)
    {
        $templates = Template::getList();
        usort($templates, function($a, $b) {
            return strcasecmp($a->getPageTemplateName(), $b->getPageTemplateName());
        });
        $items = array();
        foreach($templates as $template) {
            $item = new TargetItem($this);
            $item->setItemId($template->getPageTemplateID());
            $item->setItemName($template->getPageTemplateName());
            $items[] = $item;
        }
        return $items;
    }



}