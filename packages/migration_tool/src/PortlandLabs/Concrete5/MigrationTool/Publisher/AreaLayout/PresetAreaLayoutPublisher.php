<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AreaLayout;

use Concrete\Core\Area\Layout\Preset\Preset;
use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Package\Package;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\AreaLayout;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use Concrete\Core\Page\Page;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\PresetAreaLayout;
use Concrete\Core\Area\Layout\PresetLayout;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\PresetAreaLayoutColumn;

defined('C5_EXECUTE') or die("Access Denied.");

class PresetAreaLayoutPublisher implements PublisherInterface
{

    /**
     * @param PresetAreaLayout $layout
     */
    public function publish(AreaLayout $layout)
    {
        $preset = Preset::getByID($layout->getPreset());
        $arLayout = PresetLayout::add($preset);
        foreach($layout->getColumns() as $column) {
            $arLayout->addLayoutColumn();
        }
        return $arLayout;
    }


}
