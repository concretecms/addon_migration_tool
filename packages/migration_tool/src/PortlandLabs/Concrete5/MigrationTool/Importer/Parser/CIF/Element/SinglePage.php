<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\SinglePageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\TypeInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class SinglePage extends Page
{

    protected $pages = array();

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $this->simplexml = $element;
        $i = 0;
        $collection = new SinglePageObjectCollection();
        if ($this->simplexml->singlepages->page) {
            foreach($this->simplexml->singlepages->page as $node) {
                $page = $this->parsePage($node);
                $page->setPosition($i);
                $i++;
                $collection->getPages()->add($page);
                $page->setCollection($collection);
            }
        }
        return $collection;
    }


    protected function parsePage($node)
    {
        $page = parent::parsePage($node);
        $page->setFilename((string) $node['filename']);
        if (isset($node['root']) && $node['root'] == true) {
            $page->setIsAtRoot(true);
        }
        return $page;
    }

}
