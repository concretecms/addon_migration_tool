<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Category;

use PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Key\BooleanImporter;
use PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Value\Importer;
use PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Value\StandardImporter;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends \Concrete\Core\Support\Manager
{

    public function createFileDriver()
    {
        return new FileImporter();
    }

    public function createCollectionDriver() /* page */
    {
        return new CollectionImporter();
    }

    public function createUserDriver()
    {
        return new UserImporter();
    }

}
