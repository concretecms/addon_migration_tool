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
class PresetAreaLayout extends AreaLayout
{

    /**
     * @Column(type="string")
     */
    protected $preset;

    /**
     * @return mixed
     */
    public function getPreset()
    {
        return $this->preset;
    }

    /**
     * @param mixed $preset
     */
    public function setPreset($preset)
    {
        $this->preset = $preset;
    }




}
