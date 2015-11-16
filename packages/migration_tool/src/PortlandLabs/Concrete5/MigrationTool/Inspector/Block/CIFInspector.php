<?php

namespace PortlandLabs\Concrete5\MigrationTool\Inspector\Block;


use Concrete\Core\Backup\ContentImporter\ValueInspector\ValueInspector;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\BlockValue;
use PortlandLabs\Concrete5\MigrationTool\Inspector\InspectorInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CIFInspector implements InspectorInterface
{

    protected $value;

    public function __construct(BlockValue $value)
    {
        $this->value = $value;
    }

    public function getMatchedItems()
    {
        $value = $this->value->getValue();
        $inspector = \Core::make('import/value_inspector');
        $result = $inspector->inspect($value);
        $items = $result->getMatchedItems();
        return $items;
    }

}
