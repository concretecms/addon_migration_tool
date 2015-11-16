<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Block\StandardFormatter;
use PortlandLabs\Concrete5\MigrationTool\Inspector\Block\StandardInspector;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Block\Manager;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Block\StandardPublisher;

/**
 * @Entity
 */
class ThemeGridAreaLayout extends AreaLayout
{

    /**
     * @Column(type="integer")
     */
    protected $max_columns = 0;

    /**
     * @return mixed
     */
    public function getMaxColumns()
    {
        return $this->max_columns;
    }

    /**
     * @param mixed $max_columns
     */
    public function setMaxColumns($max_columns)
    {
        $this->max_columns = $max_columns;
    }


}