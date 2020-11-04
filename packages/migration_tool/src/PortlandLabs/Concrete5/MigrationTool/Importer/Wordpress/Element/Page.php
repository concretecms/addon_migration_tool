<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\SelectAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\StandardAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\TopicsAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\Sanitizer\PagePathSanitizer;
use PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\ElementParserInterface;

defined('C5_EXECUTE') or die('Access Denied.');

class Page implements ElementParserInterface
{
    private $simplexml;
    private $namespaces;
    private $base_blog_url;

    public function __construct()
    {
        $this->blockImporter = \Core::make('migration/manager/import/wordpress_block');
    }

    public function getObjectCollection(\SimpleXMLElement $element, array $namespaces)
    {
        $this->simplexml = $element;
        $this->namespaces = $namespaces;

        $base_url = $element->xpath('/rss/channel/wp:base_site_url');
        $base_url = (string) trim(isset($base_url[0]) ? $base_url[0] : '');

        $base_blog_url = $element->xpath('/rss/channel/wp:base_blog_url');
        if ($base_blog_url) {
            $this->base_blog_url = (string) trim($base_blog_url[0]);
        } else {
            $this->base_blog_url = $base_url;
        }

        $collection = new PageObjectCollection();
        $pages = $this->createParentPages();
        foreach ($this->getPageNodes() as $node) {
            $pages[] = $this->parsePage($node);
        }

        // Order pages by its path so parent pages are created first
        usort($pages, [$this, 'comparePath']);

        $i = 0;
        foreach ($pages as $page) {
            $page->setPosition($i);
            ++$i;
            $collection->getPages()->add($page);
            $page->setCollection($collection);

            // Do not Normalize path when processing the batch later on
            $page->setNormalizePath(false);
        }

        return $collection;
    }

    public function getPageNodes()
    {
        $pages = [];
        foreach ($this->simplexml->channel->item as $item) {
            $pageType = $this->getPageType($item);
            if ($pageType == 'page' || $pageType == 'blog_entry') {
                $pages[] = $item;
            }
        }

        return $pages;
    }

    protected function parsePage($node)
    {
        $pageType = $this->getPageType($node);
        $wp = $node->children($this->namespaces['wp']);

        $page = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page();
        $page->setName((string) html_entity_decode($node->title));
        $page->setPublicDate((string) $wp->post_date);
        $page->setDescription((string) html_entity_decode($node->description));
        $page->setType($pageType);
        $page->setTemplate('blank');

        $page->setOriginalPath($this->createOriginalPath($node));
        $page->setBatchPath($this->createBatchPath($page->getOriginalPath(), $pageType));

        $page->setUser($this->getUser($node));

        $this->parseCategories($page, $node);
        $this->parsePostmeta($page, $node);

        $area = $this->parseArea($node);
        $area->setPage($page);
        $page->areas->add($area);

        return $page;
    }

    private function getItemType(\SimpleXMLElement $node)
    {
        $wp = $node->children($this->namespaces['wp']);

        return (string) $wp->post_type;
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

        return isset($pageType) ? $pageType : $itemType;
    }

    private function createOriginalPath($node)
    {
        $path = parse_url($node->link, PHP_URL_PATH);
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if (substr($path, -strlen($ext)) === $ext) {
            $path = substr($path, 0, strlen($path) - strlen($ext) - 1);
        }

        $blogPath = parse_url($this->base_blog_url, PHP_URL_PATH);
        if (strpos($path, $blogPath) === 0) {
            $path = substr($path, strlen($blogPath));
        }
        $path = rtrim($path, '/');

        if (!$path) {
            // TODO create validation warning on items that have a generated path
            $path = '/imported-item-without-original-path-' . (string) $node->xpath('wp:post_id')[0];
        }

        return strtolower($path);
    }

    private function createBatchPath($originalPath, $pageType)
    {
        $sanitizer = new PagePathSanitizer();
        $originalPath = $sanitizer->sanitize($originalPath);
        $URIParts = explode('/', $originalPath);
        $URIParts = array_filter($URIParts);

        if ($pageType == 'blog_entry') {
            $batchPath = '/posts/' . end($URIParts);
        } elseif ($pageType == 'page') {
            // TODO construct the page path looking at the <wp:post_parent> link + the current item's name
            $batchPath = '/pages' . $originalPath;
        }

        return $batchPath;
    }

    private function createParentPages()
    {
        $pages = [];
        $parentPages = [
            'posts' => 'Posts',
            'pages' => 'Pages',
        ];

        foreach ($parentPages as $parentPagePath => $parentPageName) {
            $page = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page();
            $page->setName('Wordpress ' . $parentPageName . ' (Auto-generated)');
            $page->setDescription('Auto-generated parent page to hold Wordpress ' . $parentPageName);
            $page->setPublicDate(date('Y-m-d H:i:s'));
            $page->setType('page');
            $page->setOriginalPath('/' . $parentPagePath);
            $page->setBatchPath('/' . $parentPagePath);
            $page->setTemplate('blank');
            $page->setUser('admin');
            $pages[] = $page;
        }

        return $pages;
    }

    private function comparePath($a, $b)
    {
        return strcmp($a->getBatchPath(), $b->getBatchPath());
    }

    private function getUser(\SimpleXMLElement $node)
    {
        $dc = $node->children($this->namespaces['dc']);

        return (string) $dc->creator;
    }

    private function parseArea(\SimpleXMLElement $node)
    {
        $area = new Area();
        $area->setName('Main');

        $block = $this->parseBlocks($node);
        $block->setArea($area);
        $area->blocks->add($block);

        return $area;
    }

    private function parseBlocks(\SimpleXMLElement $node)
    {
        // TODO parse content, detect other blocks and create them
        $block = new Block();
        $block->setType('Content');
        $block->setName('Content');
        $value = $this->blockImporter->driver('unmapped')->parse($node);
        $block->setBlockValue($value);
        $block->setPosition(1);

        return $block;
    }

    private function parseCategories(\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page $page, \SimpleXMLElement $node)
    {
        $categories = [];
        $tags = [];
        foreach ($node->category as $c) {
            $att = $c->attributes();
            if (isset($att['domain'])) {
                $domain = (string) $att['domain'];
                switch ($domain) {
                    case 'category':
                        $categories[] = '/' . $c;
                        break;
                    case 'post_tag':
                        $tags[] = (string) $c;
                        break;
                }
            }
        }

        if (count($categories) > 0) {
            $attribute = new Attribute();
            $attribute->setHandle('blog_entry_topics');
            $value = new TopicsAttributeValue();
            $value->setValue($categories);
            $attribute->setAttributeValue($value);
            $pageAttribute = new PageAttribute();
            $pageAttribute->setAttribute($attribute);
            $pageAttribute->setPage($page);
            $page->attributes->add($pageAttribute);
        }

        if (count($tags) > 0) {
            $attribute = new Attribute();
            $attribute->setHandle('tags');
            $value = new SelectAttributeValue();
            $value->setValue($tags);
            $attribute->setAttributeValue($value);
            $pageAttribute = new PageAttribute();
            $pageAttribute->setAttribute($attribute);
            $pageAttribute->setPage($page);
            $page->attributes->add($pageAttribute);
        }
    }

    private function parsePostmeta(\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page $page, \SimpleXMLElement $node)
    {
        $wp = $node->children($this->namespaces['wp']);
        foreach ($wp->postmeta as $meta) {
            $attribute = new Attribute();
            $attribute->setHandle((string) $meta->meta_key);
            $value = new StandardAttributeValue();
            $value->setValue((string) $meta->meta_value);
            $attribute->setAttributeValue($value);
            $pageAttribute = new PageAttribute();
            $pageAttribute->setAttribute($attribute);
            $pageAttribute->setPage($page);
            $page->attributes->add($pageAttribute);
        }
    }
}
