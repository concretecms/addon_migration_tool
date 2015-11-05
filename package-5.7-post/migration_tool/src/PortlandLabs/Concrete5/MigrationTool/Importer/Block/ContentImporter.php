<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Block;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ContentBlockValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\StandardBlockDataRecord;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\StandardBlockValue;
use PortlandLabs\Concrete5\MigrationTool\Importer\ImporterInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ContentImporter extends StandardImporter
{
    public function createBlockValueObject()
    {
        return new ContentBlockValue();
    }

}
