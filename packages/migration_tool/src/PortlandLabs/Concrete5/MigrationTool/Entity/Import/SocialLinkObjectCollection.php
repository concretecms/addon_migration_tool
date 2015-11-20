<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\Formatter\AttributeTypeFormatter;
use PortlandLabs\Concrete5\MigrationTool\Importer\Formatter\BlockTypeFormatter;
use PortlandLabs\Concrete5\MigrationTool\Importer\Formatter\PageTemplateFormatter;
use PortlandLabs\Concrete5\MigrationTool\Importer\Formatter\SocialLinkFormatter;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

/**
 * @Entity
 */
class SocialLinkObjectCollection extends ObjectCollection
{

    /**
     * @OneToMany(targetEntity="SocialLink", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $links;

    public function __construct()
    {
        $this->links = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getLinks()
    {
        return $this->links;
    }

    public function getFormatter()
    {
        return new SocialLinkFormatter($this);
    }

    public function getType()
    {
        return 'social_link';
    }

    public function hasRecords()
    {
        return count($this->getLinks());
    }

    public function getRecords()
    {
        return $this->getLinks();
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
