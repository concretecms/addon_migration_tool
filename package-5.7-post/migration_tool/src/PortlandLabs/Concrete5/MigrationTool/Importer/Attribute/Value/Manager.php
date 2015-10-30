<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Value;

use PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Value\SelectImporter;
use PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Value\Importer;
use PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Value\StandardImporter;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends \Concrete\Core\Support\Manager
{

    public function createImporterDriver()
    {
        return new Importer();
    }

    public function getDefaultDriver()
    {
        return 'importer';
    }

    public function createTextDriver()
    {
        return new StandardImporter();
    }

    public function createTextAreaDriver()
    {
        return new StandardImporter();
    }

    public function createBooleanDriver()
    {
        return new StandardImporter();
    }

    public function createDateTimeDriver()
    {
        return new StandardImporter();
    }

    public function createRatingDriver()
    {
        return new StandardImporter();
    }

    public function createSelectDriver()
    {
        return new SelectImporter();
    }



}
