<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer;

defined('C5_EXECUTE') or die("Access Denied.");

interface FileParserInterface
{
    public function getDriver();
    public function getName();
    public function validateUploadedFile(array $file, &$error);

    /**
     * @param $file
     *
     * @return \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch[]
     */
    public function getContentObjectCollections($file);
}
