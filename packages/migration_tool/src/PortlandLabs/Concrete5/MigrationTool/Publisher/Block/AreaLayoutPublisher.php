<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Block;


use Concrete\Core\Area\SubArea;
use Concrete\Core\Backup\ContentImporter;
use Concrete\Core\Legacy\BlockRecord;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\BlockValue;
use Concrete\Core\Page\Page;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\AreaLayoutBlockValue;
use Concrete\Core\Block\BlockType\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Block\PublisherInterface as BlockPublisherInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Routine\PublishPageContentRoutine;

defined('C5_EXECUTE') or die("Access Denied.");

class AreaLayoutPublisher implements PublisherInterface
{

    public function publish(Batch $batch, BlockType $bt, Page $page, Area $area, BlockValue $value)
    {
        $routine = new PublishPageContentRoutine();
        $routine->setBatch($batch);

        /* @var $value AreaLayoutBlockValue */
        $layout = $value->getAreaLayout();
        $publisher = $layout->getPublisher();
        $layoutObject = $publisher->publish($layout);
        $columns = $layout->getColumns();
        $i = 0;
        $layoutBlock = $page->addBlock($bt, $area->getName(), array('arLayoutID' => $layoutObject->getAreaLayoutID()));
        foreach($layoutObject->getAreaLayoutColumns() as $columnObject) {
            $column = $columns[$i];
            foreach ($column->getBlocks() as $block) {
                $subValue = $block->getBlockValue();
                $publisher = $subValue->getPublisher();
                $subarea = new Area();
                $subAreaName = $area->getName() . SubArea::AREA_SUB_DELIMITER . $columnObject->getAreaLayoutColumnDisplayID();
                $subarea->setName($subAreaName);
                /**
                 * @var $publisher BlockPublisherInterface
                 */
                $subBlockType = $routine->getTargetItem('block_type', $block->getType());
                if (is_object($subBlockType)) {
                    $publisher->publish($batch, $subBlockType, $page, $subarea, $subValue);
                }
            }
            $i++;
        }
        return $layoutBlock;
    }

}
