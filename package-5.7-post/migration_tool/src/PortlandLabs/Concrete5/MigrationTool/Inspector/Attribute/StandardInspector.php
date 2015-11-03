<?php

namespace PortlandLabs\Concrete5\MigrationTool\Inspector\Attribute;

use Concrete\Core\Backup\ContentImporter\ValueInspector\ValueInspector;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue;
use PortlandLabs\Concrete5\MigrationTool\Inspector\InspectorInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardInspector implements InspectorInterface
{

    protected $value;

    public function __construct(AttributeValue $value)
    {
        $this->value = $value;
    }

    public function getMatchedItems()
    {
        $value = $this->value->getValue();
        $inspector = new ValueInspector($value);
        $items = $inspector->getMatchedItems();
        return $items;
    }
}
