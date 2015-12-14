<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Feed;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreatePageFeedsRoutine implements RoutineInterface
{
    public function execute(Batch $batch)
    {
        $inspector = \Core::make('import/value_inspector');
        $feeds = $batch->getObjectCollection('page_feed');

        if (!$feeds) {
            return;
        }

        foreach ($feeds->getFeeds() as $feed) {
            if (!$feed->getPublisherValidator()->skipItem()) {
                $f = new Feed();
                $parentID = intval($inspector->inspect($feed->getParent())->getReplacedValue());
                $pageType = intval($inspector->inspect($feed->getPageType())->getReplacedValue());
                $f->setTitle($feed->getTitle());
                $f->setHandle($feed->getHandle());
                $f->setDescription($feed->getDescription());
                $f->setParentID($parentID);
                $f->setPageTypeID($pageType);
                $f->setIncludeAllDescendents($feed->getIncludeAllDescendants());
                $f->setDisplayFeaturedOnly($feed->getDisplayFeaturedOnly());
                $f->setDisplayAliases($feed->getDisplayAliases());
                if ($feed->getContentType() == 'description') {
                    $f->displayShortDescriptionContent();
                } else {
                    $f->displayAreaContent($feed->getContentTypeArea());
                }
                $f->save();
            }
        }
    }
}
