<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateWorkflowProgressCategoriesCommandHandler extends AbstractHandler
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $types = $batch->getObjectCollection('workflow_progress_category');

        if (!$types) {
            return;
        }

        foreach ($types->getCategories() as $category) {
            if (!$category->getPublisherValidator()->skipItem()) {
                $logger->logPublishStarted($category);
                $pkg = null;
                if ($category->getPackage()) {
                    $pkg = \Package::getByHandle($category->getPackage());
                }
                \Concrete\Core\Workflow\Progress\Category::add($category->getHandle(), $pkg);
                $logger->logPublishComplete($category);
            } else {
                $logger->logSkipped($category);
            }
        }
    }
}
