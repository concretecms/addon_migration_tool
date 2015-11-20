<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\Formatter\JobFormatter;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

/**
 * @Entity
 */
class JobObjectCollection extends ObjectCollection
{

    /**
     * @OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Job", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $jobs;

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    public function getFormatter()
    {
        return new JobFormatter($this);
    }

    public function getType()
    {
        return 'job';
    }

    public function hasRecords()
    {
        return count($this->getJobs());
    }

    public function getRecords()
    {
        return $this->getJobs();
    }

    public function getTreeFormatter()
    {
        return false;
    }

    public function getRecordValidator(Batch $batch)
    {
        return false;
    }





}
