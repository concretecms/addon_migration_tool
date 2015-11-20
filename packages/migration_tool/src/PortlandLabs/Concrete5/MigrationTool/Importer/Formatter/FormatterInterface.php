<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Formatter;

defined('C5_EXECUTE') or die("Access Denied.");

interface FormatterInterface
{

    public function getPluralDisplayName();
    public function getElement();
    public function displayObjectCollection();

}