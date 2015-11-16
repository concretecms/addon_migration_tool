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
class CustomAreaLayout extends AreaLayout
{

    /**
     * @Column(type="integer")
     */
    protected $spacing = 0;

    /**
     * @Column(type="boolean")
     */
    protected $has_custom_widths = false;

    /**
     * @return mixed
     */
    public function getSpacing()
    {
        return $this->spacing;
    }

    /**
     * @param mixed $spacing
     */
    public function setSpacing($spacing)
    {
        $this->spacing = $spacing;
    }

    /**
     * @return mixed
     */
    public function getHasCustomWidths()
    {
        return $this->has_custom_widths;
    }

    /**
     * @param mixed $has_custom_widths
     */
    public function setHasCustomWidths($has_custom_widths)
    {
        $this->has_custom_widths = $has_custom_widths;
    }




}
