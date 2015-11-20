<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Block;

use Concrete\Core\Support\Manager as CoreManager;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Block\Importer;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Block\StandardImporter;

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
        return 'standard';
    }

    public function createStandardDriver()
    {
        return new StandardPublisher();
    }

    public function __construct($app)
    {
        parent::__construct($app);
        $this->extend('content', function() {
            return new ContentPublisher();
        });
    }




}
