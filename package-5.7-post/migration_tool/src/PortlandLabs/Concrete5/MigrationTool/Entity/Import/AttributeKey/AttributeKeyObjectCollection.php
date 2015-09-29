<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Formatter\AttributeKeyFormatter;

/**
 * @Entity
 */
class AttributeKeyObjectCollection extends ObjectCollection
{

    /**
     * @OneToMany(targetEntity="AttributeKey", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $keys;

    public function __construct()
    {
        $this->keys = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getKeys()
    {
        return $this->keys;
    }

    public function getFormatter()
    {
        return new AttributeKeyFormatter($this);
    }

    public function getType()
    {
        return 'attribute_key';
    }

    public function hasRecords()
    {
        return count($this->getKeys());
    }


}
