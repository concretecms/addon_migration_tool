<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute\SocialLinksFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute\StandardFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute\SelectFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute\SocialLinksPublisher;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute\StandardPublisher;

/**
 * @Entity
 * @Table(name="MigrationImportAttributeSocialLinksValues")
 */
class SocialLinksAttributeValue extends AttributeValue
{

    /**
     * @Column(type="json_array")
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
        return new SocialLinksFormatter($this);
    }

    public function getPublisher()
    {
        return new SocialLinksPublisher();
    }


}
