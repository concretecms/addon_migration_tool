<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Block;

use Concrete\Core\Sharing\SocialNetwork\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\BlockValue;
use Concrete\Core\Page\Page;
use Concrete\Core\Block\BlockType\BlockType;

defined('C5_EXECUTE') or die("Access Denied.");

class SocialLinksPublisher implements PublisherInterface
{
    public function publish(Batch $batch, BlockType $bt, Page $page, Area $area, BlockValue $value)
    {
        $data = array();
        $data['slID'] = array();
        $records = $value->getRecords();
        foreach ($records as $record) {
            $value = $record->getData();
            $value = $value['service']; // because it comes out as an array
            $socialLink = Link::getByServiceHandle($value);
            if (is_object($socialLink)) {
                $data['slID'][] = $socialLink->getID();
            }
        }

        $b = $page->addBlock($bt, $area->getName(), $data);

        return $b;
    }
}
