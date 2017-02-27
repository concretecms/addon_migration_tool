<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Category;

defined('C5_EXECUTE') or die('Access Denied.');

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
