<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress;

use Concrete\Core\Error\Error;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\FileParserInterface;
use PortlandLabs\Concrete5\MigrationTool\Importer\ParserTrait;

defined('C5_EXECUTE') or die("Access Denied.");

class WordpressParser implements FileParserInterface
{
    use ParserTrait;

    private $wxr;
    private $namespaces = array();

    public function getDriver()
    {
        return 'wordpress';
    }

    public function getName()
    {
        return t('Wordpress Content Export');
    }

    public function validateUploadedFile(array $file, &$error)
    {
        if ($file['type'] != 'text/xml') {
            $error->add(t('File does not appear to be an XML file.'));
        }

        libxml_use_internal_errors(true);
        $this->wxr = $this->getXmlContent($file['tmp_name']);
        $XMLErrors = libxml_get_errors();

        foreach ($XMLErrors as $XMLError) {
            $error->add(t('XML format error with message "%s: %s" on line %d', $XMLError->code, $XMLError->message, $XMLError->line));
        }

        if ($this->wxr) {
            $this->namespaces = $this->wxr->getDocNamespaces();
            $wxrVersion = $this->wxr->xpath('/rss/channel/wp:wxr_version');
            if (!$wxrVersion || !preg_match('/^\d+\.\d+$/', (string) $wxrVersion[0])) {
                $error->add(t('Missing or invalid WXR version number'));
            }
        }
    }

    public function addContentObjectCollectionsToBatch($file, Batch $batch)
    {
        $manager = \Core::make('migration/manager/importer/wordpress');
        $simplexml = $this->getXmlContent($file);

        foreach ($manager->getDrivers() as $driver) {
            $collection = $driver->getObjectCollection($simplexml, $this->namespaces);
            if ($collection) {
                if (!($collection instanceof ObjectCollection)) {
                    throw new \RuntimeException(t('Driver %s getObjectCollection did not return an object of the ObjectCollection type', get_class($driver)));
                } else {
                    // does this already exist ?
                    $existingCollection = $batch->getObjectCollection($collection->getType());
                    if (is_object($existingCollection)) {
                        foreach($collection->getRecords() as $record) {
                            $record->setCollection($existingCollection);
                            $existingCollection->getRecords()->add($record);
                        }
                    } else {
                        $batch->getObjectCollections()->add($collection);
                    }
                }
            }
        }
    }
}
