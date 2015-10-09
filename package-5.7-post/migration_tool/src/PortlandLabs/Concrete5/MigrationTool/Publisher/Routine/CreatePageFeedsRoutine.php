<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Backup\ContentImporter\ValueInspector\ValueInspector;
use Concrete\Core\Page\Feed;
use Concrete\Core\Page\Template;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreatePageFeedsRoutine implements RoutineInterface
{

    public function execute(Batch $batch)
    {

        $feeds = $batch->getObjectCollection('page_feed');
        foreach($feeds->getFeeds() as $feed) {
            if (!$feed->getPublisherValidator()->skipItem()) {
                $f = new Feed();
                $parentID = intval(id(new ValueInspector($feed->getParent()))->getReplacedContent());
                $pageType = intval(id(new ValueInspector($feed->getPageType()))->getReplacedContent());
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