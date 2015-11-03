<?php

namespace PortlandLabs\Concrete5\MigrationTool\Inspector;

use Concrete\Core\Backup\ContentImporter\ValueInspector\ValueInspector;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageFeed;

defined('C5_EXECUTE') or die("Access Denied.");

class PageFeedInspector implements InspectorInterface
{

    protected $value;

    public function __construct(PageFeed $feed)
    {
        $this->feed = $feed;
    }

    public function getMatchedItems()
    {
        $inspector = new ValueInspector($this->feed->getPageType());
        $items = array();
        $items = array_merge($items, $inspector->getMatchedItems());

        $inspector = new ValueInspector($this->feed->getParent());
        $items = array_merge($items, $inspector->getMatchedItems());

        return $items;
    }
}
