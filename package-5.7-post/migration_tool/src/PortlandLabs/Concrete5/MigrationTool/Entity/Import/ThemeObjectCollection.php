<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Formatter\AttributeTypeFormatter;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Formatter\BlockTypeFormatter;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Formatter\PageTemplateFormatter;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Formatter\ThemeFormatter;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

/**
 * @Entity
 */
class ThemeObjectCollection extends ObjectCollection
{

    /**
     * @OneToMany(targetEntity="Theme", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $themes;

    public function __construct()
    {
        $this->themes = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getThemes()
    {
        return $this->themes;
    }

    public function getFormatter()
    {
        return new ThemeFormatter($this);
    }

    public function getType()
    {
        return 'theme';
    }

    public function hasRecords()
    {
        return count($this->getThemes());
    }

    public function getRecords()
    {
        return $this->getThemes();
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
