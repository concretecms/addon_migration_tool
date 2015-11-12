<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\ContentType;

defined('C5_EXECUTE') or die("Access Denied.");

interface TypeInterface
{

    public function getObjectCollection(\SimpleXMLElement $xml);


}