<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Block;


use Concrete\Core\Backup\ContentImporter;
use Concrete\Core\Legacy\BlockRecord;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\BlockValue;
use Concrete\Core\Page\Page;
use Concrete\Core\Block\BlockType\BlockType;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardPublisher implements PublisherInterface
{

    public function publish(Batch $batch, BlockType $bt, Page $page, Area $area, BlockValue $value)
    {
        $records = $value->getRecords();
        $inspector = \Core::make('import/value_inspector');
        if (count($records) == 1) {
            $data = array();
            foreach($records[0]->getData() as $key => $value) {
                $result = $inspector->inspect($value);
                $data[$key] = $result->getReplacedValue();
            }
            $b = $page->addBlock($bt, $area->getName(), $data);
        } else if (count($records) > 1) {
            foreach($records as $record) {
                if (strcasecmp($record->getTable(), $bt->getController()->getBlockTypeDatabaseTable()) == 0) {
                    // This is the data record.
                    $data = array();
                    foreach($record->getData() as $key => $value) {
                        $result = $inspector->inspect($value);
                        $data[$key] = $result->getReplacedValue();
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
                        $result = $inspector->inspect($value);
                        $aar->{$key} = $result->getReplacedValue();
                    }
                    $aar->Save();
                }
            }
        }
        return $b;

    }

}
