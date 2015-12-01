<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Block;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\BlockValue;
use Concrete\Core\Page\Page;
use Concrete\Core\Block\BlockType\BlockType;

defined('C5_EXECUTE') or die("Access Denied.");

class CIFPublisher implements PublisherInterface
{
    public function publish(Batch $batch, BlockType $bt, Page $page, Area $area, BlockValue $value)
    {
        $btc = $bt->getController();
        $bx = simplexml_load_string($value->getValue());

        return $btc->import($page, $area->getName(), $bx);
    }
}
