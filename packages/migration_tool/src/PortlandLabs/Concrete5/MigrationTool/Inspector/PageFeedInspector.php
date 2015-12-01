<?php
namespace PortlandLabs\Concrete5\MigrationTool\Inspector;

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
        $inspector = \Core::make('import/value_inspector');
        $result = $inspector->inspect($this->feed->getPageType());
        $items = $result->getMatchedItems();
        $result = $inspector->inspect($this->feed->getParent());
        $items = array_merge($items, $result->getMatchedItems());

        return $items;
    }
}
