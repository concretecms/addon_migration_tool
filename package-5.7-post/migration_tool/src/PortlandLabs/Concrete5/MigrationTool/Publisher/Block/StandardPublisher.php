<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Block;


use Concrete\Core\Backup\ContentImporter;
use Concrete\Core\Legacy\BlockRecord;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue;
use Concrete\Core\Page\Page;
use Concrete\Core\Block\BlockType\BlockType;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardPublisher implements PublisherInterface
{

    public function publish(BlockType $bt, Page $page, Area $area, BlockValue $value)
    {
        $records = $value->getRecords();
        if (count($records) == 1) {
            $data = array();
            foreach($records[0]->getData() as $key => $value) {
                $inspector = new ContentImporter\ValueInspector\ValueInspector($value);
                $data[$key] = $inspector->getReplacedValue();
                unset($inspector);
            }
            $b = $page->addBlock($bt, $area->getName(), $data);
        } else if (count($records) > 1) {
            $objectRecord = false;
            foreach($records as $record) {
                if (strcasecmp($record->getTable(), $bt->getController()->getBlockTypeDatabaseTable()) == 0) {
                    // This is the data record.
                    $data = array();
                    foreach($record->getData() as $key => $value) {
                        $data[$key] = ContentImporter::getValue($value);
                    }
                    $b = $page->addBlock($bt, $area->getName(), $data);
                }
            }
            // Now we import the OTHER records.
            foreach($records as $record) {
                if (strcasecmp($record->getTable(), $bt->getController()->getBlockTypeDatabaseTable()) != 0) {
                    $aar = new BlockRecord($record->getTable());
                    $aar->bID = $b->getBlockID();
                    foreach ($record->getData() as $key => $value) {
                        $inspector = new ContentImporter\ValueInspector\ValueInspector($value);
                        $aar->{$key} = $inspector->getReplacedValue();
                        unset($inspector);
                    }
                    $aar->Save();
                }
            }
        }
        return $b;

    }

}
