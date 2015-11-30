<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Block;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\AreaLayoutColumnBlock;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\CustomAreaLayout;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\CustomAreaLayoutColumn;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\PresetAreaLayout;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\PresetAreaLayoutColumn;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\ThemeGridAreaLayout;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\ThemeGridAreaLayoutColumn;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\AreaLayoutBlockValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\CustomAreaLayoutBlockValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\PresetAreaLayoutBlockValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StandardBlockDataRecord;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StandardBlockValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\ThemeGridAreaLayoutBlockValue;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ImporterInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\AreaLayout;

defined('C5_EXECUTE') or die("Access Denied.");

class SocialLinksImporter implements ImporterInterface
{

    public function parse(\SimpleXMLElement $node)
    {
        $value = new StandardBlockValue();
        $i = 0;
        foreach ($node->link as $linkNode) {
            $service = (string) $linkNode['service'];
            $record = new StandardBlockDataRecord();
            $record->setData($service);
            $record->setPosition($i);
            $record->setValue($value);
            $value->getRecords()->add($record);
            $i++;
        }
        return $value;
    }

}
