<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
//use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
//use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;

use PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Page implements ElementParserInterface
{
    private $simplexml;
    private $namespaces;

    public function __construct()
    {
        $this->blockImporter = \Core::make('migration/manager/import/wordpress_block');
    }

    public function getPageNodes()
    {
        $pages = array();
        foreach ($this->simplexml->channel->item as $item) {
            $wp = $item->children($this->namespaces['wp']);

            if ((string)$wp->post_type == 'page') {
                $pages[] = $item;
            }
        }

        return $pages;
    }

    public function getObjectCollection(\SimpleXMLElement $element, array $namespaces)
    {
        $this->simplexml = $element;
        $this->namespaces = $namespaces;

        $i = 0;
        $collection = new PageObjectCollection();

        foreach ($this->getPageNodes() as $node) {
            $page = $this->parsePage($node);
            $page->setPosition($i);
            ++$i;
            $collection->getPages()->add($page);
            $page->setCollection($collection);
        }

        return $collection;
    }

    protected function parsePage($node)
    {
        $page = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page();
        $page->setName((string)html_entity_decode($node->title));
        $page->setPublicDate((string) $node->xpath('wp:post_date_gmt')[0]);

        // TODO remove last slash?
        $page->setOriginalPath(parse_url($node->link, PHP_URL_PATH));
        $page->setDescription((string) html_entity_decode($node->description));

        // TODO add other kinds of pages like blog_entry, etc...
        $page->setType('page');
        $page->setTemplate('blank');

        // TODO import users
        $page->setUser('admin');

        // TODO add page to parent page with wp:post_parent?
        // TODO save page as published or not published based on the WXR field wp:status?
        // TODO wp:menu_order?
        // TODO what todo with wp:postmeta?

        $area = new Area();
        $area->setName('Main');

        $block = new Block();
        $block->setType('Content');
        $block->setName('Content');
        $value = $this->blockImporter->driver('standard')->parse($node);
        $block->setBlockValue($value);

        $block->setPosition(1);
        $block->setArea($area);
        $area->blocks->add($block);

        $area->setPage($page);
        $page->areas->add($area);

        return $page;
    }
}
