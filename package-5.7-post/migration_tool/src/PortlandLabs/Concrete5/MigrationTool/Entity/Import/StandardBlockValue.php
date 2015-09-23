<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Block\StandardFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Block\StandardPublisher;

/**
 * @Entity
 */
class StandardBlockValue extends BlockValue
{

    /**
     * @Column(type="json_array")
     */
    protected $data;

    public function getFormatter()
    {
        return new StandardFormatter($this);
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    public function getPublisher()
    {
        return new StandardPublisher();
    }

}
