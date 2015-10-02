<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\TreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Formatter\PageFormatter;

/**
 * @Entity
 */
class PageObjectCollection extends ObjectCollection
{

    /**
     * @OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page", mappedBy="collection", cascade={"persist", "remove"})
     * @OrderBy({"position" = "ASC"})
     **/
    public $pages;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param ArrayCollection $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }

    public function getFormatter()
    {
        return new PageFormatter($this);
    }

    public function getType()
    {
        return 'page';
    }

    public function hasRecords()
    {
        return count($this->getPages());
    }

    public function getRecords()
    {
        return $this->getPages();
    }


    public function getTreeFormatter()
    {
        return new TreeJsonFormatter($this);
    }

}
