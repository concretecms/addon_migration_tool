<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\PageType as PageTypeEntity;

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

    public function getObjectCollection(\SimpleXMLElement $element, array $namespaces)
    {
        $collection = parent::getObjectCollection($element);
        foreach ($collection->getPages() as $page) {
            $page->setType($this->pageType->getHandle());
        }

        return $collection;
    }
}
