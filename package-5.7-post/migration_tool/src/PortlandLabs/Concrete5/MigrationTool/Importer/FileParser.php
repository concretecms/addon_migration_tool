<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer;


use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\ObjectCollectionInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Type\Manager;

class FileParser
{

    protected $simplexml;
    protected $manager;
    protected $parsed = false;
    protected $collections = array();

    public function __construct($file)
    {
        $this->simplexml = simplexml_load_file($file);
        $this->manager = \Core::make('migration/manager/importer');
    }

    public function getContentObjectCollections()
    {
        if (!$this->parsed) {
            $this->parse();
        }
        return $this->collections;
    }

    protected function parse()
    {
        foreach($this->manager->getDrivers() as $driver) {
            $collection = $driver->getObjectCollection($this->simplexml);
            if ($collection) {
                if (!($collection instanceof ObjectCollection)) {
                    throw new \RuntimeException(t('Driver %s getObjectCollection did not return an object of the ObjectCollection type', get_class($driver)));
                } else {
                    $this->collections[] = $collection;
                }
            }
        }
    }

}
