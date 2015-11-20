<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIF\Attribute\Value;

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

    public function createNumberDriver()
    {
        return new StandardImporter();
    }

    public function createSelectDriver()
    {
        return new SelectImporter();
    }

    public function createImageFileDriver()
    {
        return new ImageFileImporter();
    }

    public function createSocialLinksDriver()
    {
        return new SocialLinksImporter();
    }

    public function createTopicsDriver()
    {
        return new TopicsImporter();
    }

    public function createAddressDriver()
    {
        return new AddressImporter();
    }



}
