<?php

namespace PortlandLabs\Concrete5\MigrationTool\Inspector\Block;

use Concrete\Core\Backup\ContentImporter\ValueInspector\ValueInspector;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardInspector implements InspectorInterface
{

    protected $value;

    public function __construct(BlockValue $value)
    {
        $this->value = $value;
    }

    public function getMatchedItems()
    {
        $content = $this->value->getRecords();
        $items = array();
        foreach($content as $record) {
            $data = $record->getData();
            foreach($data as $value) {
                $inspector = new ValueInspector($value);
                $items = array_merge($items, $inspector->getMatchedItems());
            }
        }
        return $items;
    }
}
