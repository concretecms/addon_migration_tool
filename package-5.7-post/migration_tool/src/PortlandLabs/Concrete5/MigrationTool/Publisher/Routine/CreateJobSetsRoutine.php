<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Attribute\Key\Category;
use Concrete\Core\Attribute\Type;
use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Block\BlockType\Set;
use Concrete\Core\Job\Job;
use Concrete\Core\Page\Template;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateJobSetsRoutine implements RoutineInterface
{

    public function execute(Batch $batch)
    {

        $sets = $batch->getObjectCollection('job_set');
        foreach($sets->getSets() as $set) {
            if (!$set->getPublisherValidator()->skipItem()) {
                $pkg = null;
                if ($set->getPackage()) {
                    $pkg = \Package::getByHandle($set->getPackage());
                }
                $set = \Concrete\Core\Job\Set::add($set->getName(), $pkg);
                $jobs = $set->getJobs();
                foreach($jobs as $handle) {
                    $j = Job::getByHandle($handle);
                    if (is_object($j)) {
                        $set->addJob($j);
                    }
                }
            }
        }
    }
}