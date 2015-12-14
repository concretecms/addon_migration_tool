<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Sharing\SocialNetwork\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateSocialLinksRoutine implements RoutineInterface
{
    public function execute(Batch $batch)
    {
        $links = $batch->getObjectCollection('social_link');

        if (!$links) {
            return;
        }

        foreach ($links->getLinks() as $link) {
            if (!$link->getPublisherValidator()->skipItem()) {
                $l = new Link();
                $l->setServiceHandle($link->getService());
                $l->setURL($link->getURL());
                $l->save();
            }
        }
    }
}
