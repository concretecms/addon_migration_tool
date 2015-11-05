<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Block\ImportedFormatter;
use PortlandLabs\Concrete5\MigrationTool\Inspector\Block\CIFInspector;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Block\CIFPublisher;

/**
 * @Entity
 */
class ImportedBlockValue extends BlockValue
{

    /**
     * @Column(type="text", nullable=true)
     */
    protected $value;

    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getFormatter()
    {
        return new ImportedFormatter($this);
    }

    public function getPublisher()
    {
        return new CIFPublisher();
    }

    public function getInspector()
    {
        return new CIFInspector($this);
    }


}
