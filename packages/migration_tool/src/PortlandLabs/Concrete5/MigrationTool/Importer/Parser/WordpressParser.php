<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Parser;

use Concrete\Core\Error\Error;

defined('C5_EXECUTE') or die("Access Denied.");

class WordpressParser implements FileParserInterface
{

    public function getDriver()
    {
        return 'wordpress';
    }

    public function getName()
    {
        return t('Wordpress Content Export');
    }

    public function validateUploadedFile(array $file, Error &$error)
    {
        // Note –we should add real validation to this file.
        return true;
    }

    public function getContentObjectCollections($file)
    {
        // This is where we need to do the magic. Parse the wordpress file into the concrete5 objects.
        return array();
    }


}
