<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Manager;

use Concrete\Core\Support\Manager as CoreManager;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends CoreManager
{

    public function driver($driver = null)
    {
        // If a custom driver is not registered for our page type validator, we return the default.
        if (!isset($this->customCreators[$driver])) {
            return $this->getDefaultDriver();
        }
        return parent::driver($driver);
    }

}
