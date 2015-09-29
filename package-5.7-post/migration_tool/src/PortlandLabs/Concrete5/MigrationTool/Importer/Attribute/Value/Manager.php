<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Value;

use PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Value\Importer;
use PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Value\StandardImporter;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends \Concrete\Core\Support\Manager
{

    public function driver($driver = null)
    {
        // If a custom driver is not registered for our page type validator, we return the default.
        if (!isset($this->customCreators[$driver])) {
            return $this->getDefaultDriver();
        }
        return parent::driver($driver);
    }

    protected function getDefaultDriver()
    {
        return new StandardImporter();
    }

    public function __construct($app)
    {
        parent::__construct($app);
        $this->extend('unmapped', function() {
            return new Importer();
        });
    }

}
