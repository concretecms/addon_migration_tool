<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Type;

use Concrete\Core\Support\Manager as CoreManager;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends CoreManager
{

    protected function getDefaultDriver()
    {
        return new StandardImporter();
    }

    public function driver($driver = null)
    {
        // If a custom driver is not registered for our page type validator, we return the default.
        if (!isset($this->customCreators[$driver])) {
            return $this->getDefaultDriver();
        }
        return parent::driver($driver);
    }

    public function __construct($app)
    {
        parent::__construct($app);
        $this->extend('unmapped', function() {
            return new Importer();
        });
    }


}
