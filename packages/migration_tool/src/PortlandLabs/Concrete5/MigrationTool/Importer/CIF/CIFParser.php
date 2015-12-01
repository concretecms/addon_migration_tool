<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF;

use Concrete\Core\Error\Error;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\FileParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CIFParser implements FileParserInterface
{
    public function getDriver()
    {
        return 'concrete5';
    }

    public function getName()
    {
        return t('concrete5 XML Export');
    }

    public function validateUploadedFile(array $file, Error &$error)
    {
        if ($file['type'] != 'text/xml') {
            $error->add(t('File does not appear to be an XML file.'));
        }
    }

    public function getContentObjectCollections($file)
    {
        $manager = \Core::make('migration/manager/importer/cif');
        $simplexml = simplexml_load_file($file);
        $collections = array();
        foreach ($manager->getDrivers() as $driver) {
            $collection = $driver->getObjectCollection($simplexml);
            if ($collection) {
                if (!($collection instanceof ObjectCollection)) {
                    throw new \RuntimeException(t('Driver %s getObjectCollection did not return an object of the ObjectCollection type', get_class($driver)));
                } else {
                    $collections[] = $collection;
                }
            }
        }

        return $collections;
    }
}
