<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
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

            $pageType = $this->getPageType($item);
            if ($pageType == 'page' || $pageType == 'blog_entry') {
                $pages[] = $item;
            }
        }

        return $pages;
    }

    private function getItemType(\SimpleXMLElement $node)
    {
        $wp = $node->children($this->namespaces['wp']);
        return (string)$wp->post_type;
    }

    private function createParentPages()
    {
        $pages = array();
        $parentPages = array(
            'blog-posts' => 'Blog posts',
            'pages' => 'Pages'
        );

        foreach ($parentPages as $parentPagePath => $parentPageName) {
            $page = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page();
            $page->setName('Auto-generated parent for ' . $parentPageName);
            $page->setDescription('Auto-generated page for ' . $parentPageName);
            $page->setPublicDate(date('Y-m-d H:i:s'));
            $page->setType('page');
            $page->setOriginalPath('/' . $parentPagePath);
            $page->setTemplate('blank');
            $page->setUser('admin');
            $pages[] = $page;
        }

        return $pages;
    }

    public function getObjectCollection(\SimpleXMLElement $element, array $namespaces)
    {
        $this->simplexml = $element;
        $this->namespaces = $namespaces;

        $collection = new PageObjectCollection();
        $pages = array();

        foreach ($this->getPageNodes() as $node) {
            $pages[] = $this->parsePage($node);
        }

        $pages = array_merge($pages, $this->createParentPages());

        // Order pages by its path so parent pages are created first
        usort($pages, array($this, 'comparePath'));

        // TODO check if parents exists, then adapt it and show warning message

        $i = 0;
        foreach ($pages as $page) {
            $page->setPosition($i);
            ++$i;
            $collection->getPages()->add($page);
            $page->setCollection($collection);
        }

        return $collection;
    }

    private function comparePath($a, $b)
    {
        return strcmp($a->getOriginalPath(), $b->getOriginalPath());
    }

    private function createPath($path, $node, $pageType)
    {
        $path = parse_url($path, PHP_URL_PATH);
        $path = rtrim($path, '/');

        if (!$path) {
            // TODO create validation error
//            $path = '/' . $node->title . '-' . (string)$node->xpath('wp:post_id')[0];
        }

        $path = $pageType == 'blog_entry' ? '/blog-posts' . $path : '/pages' . $path;

        return strtolower($path);
    }

    private function getUser(\SimpleXMLElement $node)
    {
        $dc = $node->children('http://purl.org/dc/elements/1.1/');
        return (string)$dc->creator;
    }

    protected function parsePage($node)
    {
        $pageType = $this->getPageType($node);

        $page = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page();
        $page->setName((string)html_entity_decode($node->title));
        $page->setPublicDate((string)$node->xpath('wp:post_date_gmt')[0]);
        $page->setDescription((string)html_entity_decode($node->description));
        $page->setType($pageType);
        $page->setOriginalPath($this->createPath($node->link, $node, $pageType));
        $page->setTemplate('blank');
//        $page->setUser($this->getUser($node));
        // TODO remove temporary user assignment
        $page->setUser('admin');

        // wp:status = publish | pending, draft or invalid = not publishable
        // version cvIsApproved = 0 | 1
        // wp:status = private, having wp:post_password or invalid = change permissions to just admins

        $area = $this->parseArea($node);
        $area->setPage($page);
        $page->areas->add($area);

        return $page;
    }

    private function getPageType($node)
    {
        $itemType = $this->getItemType($node);

        switch ($itemType) {
            case 'post':
                $pageType = 'blog_entry';
                break;
            case 'page':
                $pageType = 'page';
                break;
        }

        return $pageType;
    }

    private function parseArea($node)
    {
        $area = new Area();
        $area->setName('Main');

        $block = $this->parseBlocks($node);
        $block->setArea($area);
        $area->blocks->add($block);

        return $area;
    }

    private function parseBlocks($node)
    {
        // TODO parse content, detect other blocks and create them
        $block = new Block();
        $block->setType('Content');
        $block->setName('Content');
        $value = $this->blockImporter->driver('standard')->parse($node);
        $block->setBlockValue($value);
        $block->setPosition(1);

        return $block;
    }
}
