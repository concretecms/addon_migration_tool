<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Tree\TreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Formatter\ThumbnailTypeFormatter;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Formatter\TreeFormatter;

/**
 * @Entity
 */
class TreeObjectCollection extends ObjectCollection
{

    /**
     * @OneToMany(targetEntity="Tree", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $trees;

    public function __construct()
    {
        $this->trees = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getTrees()
    {
        return $this->trees;
    }

    public function getFormatter()
    {
        return new TreeFormatter($this);
    }

    public function getType()
    {
        return 'tree';
    }

    public function hasRecords()
    {
        return count($this->getTrees());
    }

    public function getRecords()
    {
        return $this->getTrees();
    }

    public function getTreeFormatter()
    {
        return new TreeJsonFormatter($this);
    }

    public function getRecordValidator()
    {
        return false;
    }





}
