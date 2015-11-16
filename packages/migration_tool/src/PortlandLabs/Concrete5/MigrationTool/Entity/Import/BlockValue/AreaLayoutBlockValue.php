<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Block\StandardFormatter;
use PortlandLabs\Concrete5\MigrationTool\Inspector\Block\StandardInspector;

/**
 * @Table(name="MigrationImportAreaLayoutBlockValues")
 * @Entity
 */
class AreaLayoutBlockValue extends BlockValue
{

    /**
     * @OneToOne(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\AreaLayout", inversedBy="block_value", cascade={"persist", "remove"})
     **/
    protected $area_layout;


    /**
     * @return mixed
     */
    public function getAreaLayout()
    {
        return $this->area_layout;
    }

    /**
     * @param mixed $area_layout
     */
    public function setAreaLayout($area_layout)
    {
        $this->area_layout = $area_layout;
    }

    public function getInspector()
    {
        return new StandardInspector($this);
    }

    public function getFormatter()
    {
        return new StandardFormatter($this);
    }

    public function getPublisher()
    {
        return new AreaLayoutBlockPublisher();
    }




}
