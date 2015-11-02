<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute\StandardFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute\SelectFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Attribute\ImageFileValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Attribute\StandardValidator;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Inspector\Attribute\StandardInspector;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute\ImageFilePublisher;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute\StandardPublisher;

/**
 * @Entity
 * @Table(name="MigrationImportAttributeImageFileValues")
 */
class ImageFileAttributeValue extends AttributeValue
{

    /**
     * @Column(type="text")
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
        return new StandardFormatter($this);
    }

    public function getPublisher()
    {
        return new ImageFilePublisher();
    }

    public function getRecordValidator(Batch $batch)
    {
        return new StandardValidator($batch);
    }

    public function getInspector()
    {
        return new StandardInspector($this);
    }





}
