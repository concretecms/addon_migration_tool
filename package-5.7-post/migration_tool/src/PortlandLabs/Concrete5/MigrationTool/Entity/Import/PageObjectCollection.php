<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;

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



}
