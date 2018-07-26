<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler;

use Concrete\Core\Entity\Sharing\SocialNetwork\Link;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateSocialLinksCommandHandler extends AbstractHandler
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $links = $batch->getObjectCollection('social_link');

        if (!$links) {
            return;
        }

        foreach ($links->getLinks() as $link) {
            if (!$link->getPublisherValidator()->skipItem()) {
                $logger->logPublishStarted($link);
                $l = new Link();
                $l->setServiceHandle($link->getService());
                $l->setSite($batch->getSite());
                $l->setURL($link->getURL());
                $l->save();
                $logger->logPublishComplete($link, $l);
            } else {
                $logger->logSkipped($link);
            }
        }
    }
}
