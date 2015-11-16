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
class ThemeGridAreaLayoutColumn extends AreaLayoutColumn
{

    /**
     * @Column(type="integer")
     */
    protected $span = 0;

    /**
     * @Column(type="integer")
     */
    protected $offset = 0;

    /**
     * @return mixed
     */
    public function getSpan()
    {
        return $this->span;
    }

    /**
     * @param mixed $span
     */
    public function setSpan($span)
    {
        $this->span = $span;
    }

    /**
     * @return mixed
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param mixed $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }




}
