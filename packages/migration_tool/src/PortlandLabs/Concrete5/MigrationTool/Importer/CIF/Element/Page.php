<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;

use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Page implements ElementParserInterface
{
    protected $attributeImporter;
    protected $blockImporter;
    protected $simplexml;
    protected $pages = array();

    public function __construct()
    {
        $this->attributeImporter = \Core::make('migration/manager/import/attribute/value');
        $this->blockImporter = \Core::make('migration/manager/import/cif_block');
        $this->styleSetImporter = new StyleSet();
    }

    public function hasPageNodes()
    {
        return isset($this->simplexml->pages->page);
    }

    public function getPageNodes()
    {
        return $this->simplexml->pages->page;
    }

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $this->simplexml = $element;
        $i = 0;
        $collection = new PageObjectCollection();
        if ($this->hasPageNodes()) {
            foreach ($this->getPageNodes() as $node) {
                $page = $this->parsePage($node);
                $page->setPosition($i);
                ++$i;
                $collection->getPages()->add($page);
                $page->setCollection($collection);
            }
        }

        return $collection;
    }

    protected function convertPath($path)
    {
        $parts = explode('/', $path);
        $full = '';
        foreach ($parts as $part) {
            $txt = \Core::make('helper/text');
            $part = $txt->slugSafeString($part);
            $part = str_replace('-', \Config::get('concrete.seo.page_path_separator'), $part);
            $full .= $part . '/';
        }

        return rtrim($full, '/');
    }

    protected function parsePage($node)
    {
        $page = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page();
        $page->setName((string) html_entity_decode($node['name']));
        $page->setPublicDate((string) $node['public-date']);
        $page->setOriginalPath($this->convertPath((string) $node['path']));
        if (isset($node['package'])) {
            $page->setPackage((string) $node['package']);
        }
        $page->setTemplate((string) $node['template']);
        $page->setType((string) $node['pagetype']);
        $page->setUser((string) $node['user']);
        $page->setDescription((string) html_entity_decode($node['description']));

        // Parse attributes
        if ($node->attributes->attributekey) {
            $i = 0;
            foreach ($node->attributes->attributekey as $keyNode) {
                $attribute = $this->parseAttribute($keyNode);
                $pageAttribute = new PageAttribute();
                $pageAttribute->setAttribute($attribute);
                $pageAttribute->setPage($page);
                $page->attributes->add($pageAttribute);
                ++$i;
            }
        }

        // Parse areas
        if ($node->area) {
            foreach ($node->area as $areaNode) {
                $area = $this->parseArea($areaNode);
                $area->setPage($page);
                $page->areas->add($area);
            }
        }

        return $page;
    }

    protected function parseAttribute($node)
    {
        $attribute = new Attribute();
        $attribute->setHandle((string) $node['handle']);
        $value = $this->attributeImporter->driver()->parse($node);
        $attribute->setAttributeValue($value);

        return $attribute;
    }

    protected function parseBlock($node)
    {
        $block = new Block();
        $type = (string) $node['type'];
        $block->setType($type);
        $block->setName((string) $node['name']);
        $bFilename = (string) $node['custom-template'];
        if ($bFilename) {
            $block->setCustomTemplate($bFilename);
        }
        $block->setDefaultsOutputIdentifier((string) $node['mc-block-id']);
        if (isset($node->style)) {
            $styleSet = $this->styleSetImporter->import($node->style);
            $block->setStyleSet($styleSet);
        }
        $value = $this->blockImporter->driver($type)->parse($node);
        $block->setBlockValue($value);

        return $block;
    }

    protected function parseArea($node)
    {
        $area = new Area();
        $area->setName((string) $node['name']);

        if (isset($node->style)) {
            $styleSet = $this->styleSetImporter->import($node->style);
            $area->setStyleSet($styleSet);
        }

        // Parse areas
        $nodes = false;
        if ($node->blocks->block) {
            $nodes = $node->blocks->block;
        } elseif ($node->block) {
            // 5.6
            $nodes = $node->block;
        }

        if ($nodes) {
            $i = 0;
            foreach ($nodes as $blockNode) {
                if ($blockNode['type']) {
                    $block = $this->parseBlock($blockNode);
                } elseif ($blockNode['mc-block-id'] != '') {
                    $block = new Block();
                    $block->setDefaultsOutputIdentifier((string) $blockNode['mc-block-id']);
                }
                if (isset($block)) {
                    $block->setPosition($i);
                    $block->setArea($area);
                    $area->blocks->add($block);
                    ++$i;
                }
            }
        }

        return $area;
    }
}
