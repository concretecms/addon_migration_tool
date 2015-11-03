<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Job\Job;
use Concrete\Core\Page\Template;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreatePackagesRoutine implements RoutineInterface
{
    public function execute(Batch $batch)
    {

        $packages = $batch->getObjectCollection('package');
        foreach($packages->getPackages() as $package) {
            if (!$package->getPublisherValidator()->skipItem()) {
                $pkg = \Package::getClass($package->getHandle());
                if (!$pkg->isPackageInstalled()) {
                    $pkg->install();
                }
            }
        }
    }

}
