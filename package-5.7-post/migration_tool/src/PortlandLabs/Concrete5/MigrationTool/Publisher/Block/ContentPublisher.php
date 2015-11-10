<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Block;


use Concrete\Core\Backup\ContentImporter;
use Concrete\Core\Legacy\BlockRecord;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue;
use Concrete\Core\Page\Page;
use Concrete\Core\Block\BlockType\BlockType;

defined('C5_EXECUTE') or die("Access Denied.");

class ContentPublisher implements PublisherInterface
{

    public function publish(Batch $batch, BlockType $bt, Page $page, Area $area, BlockValue $value)
    {
        $data = $value->getRecords()->get(0)->getData();
        $inspector = \Core::make('migration/import/value_inspector', array($batch));
        $result = $inspector->inspect($data['content']);
        $data['content'] = $result->getReplacedContent();
        $b = $page->addBlock($bt, $area->getName(), $data);
        return $b;
    }

}
