<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIF;

defined('C5_EXECUTE') or die("Access Denied.");

interface ElementParserInterface
{

    public function getObjectCollection(\SimpleXMLElement $xml);


}