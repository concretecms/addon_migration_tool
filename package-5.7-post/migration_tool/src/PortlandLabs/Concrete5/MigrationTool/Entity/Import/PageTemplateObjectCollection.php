<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 */
class PageTemplateObjectCollection extends ObjectCollection
{

    /**
     * @OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplate", mappedBy="collection", cascade={"persist", "remove"})
     * @OrderBy({"position" = "ASC"})
     **/
    public $templates;

    public function __construct()
    {
        $this->templates = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getTemplates()
    {
        return $this->templates;
    }


}
