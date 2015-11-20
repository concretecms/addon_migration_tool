<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\PageType as PageTypeEntity;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\SinglePageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class PageTypeDefaultPage extends Page
{

    protected $pageType;

    public function __construct(PageTypeEntity $type)
    {
        $this->pageType = $type;
        parent::__construct();
    }
    public function hasPageNodes()
    {
        return isset($this->simplexml->page);
    }

    public function getPageNodes()
    {
        return $this->simplexml->page;
    }

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $collection = parent::getObjectCollection($element);
        foreach($collection->getPages() as $page) {
            $page->setType($this->pageType->getHandle());
        }
        return $collection;
    }

}
