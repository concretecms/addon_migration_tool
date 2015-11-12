<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Block;

use Concrete\Core\Support\Manager as CoreManager;
use PortlandLabs\Concrete5\MigrationTool\Importer\Block\Importer;
use PortlandLabs\Concrete5\MigrationTool\Importer\Block\StandardImporter;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends CoreManager
{

    public function driver($driver = null)
    {
        // If a custom driver is not registered, we use unmapped
        if ($driver && !isset($this->customCreators[$driver])) {
            return $this->createStandardDriver();
        }
        return parent::driver($driver);
    }

    public function getDefaultDriver()
    {
        return 'unmapped';
    }

    public function createUnmappedDriver()
    {
        return new Importer();
    }

    public function createStandardDriver()
    {
        return new StandardImporter();
    }


}
