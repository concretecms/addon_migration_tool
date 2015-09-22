<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Type;

defined('C5_EXECUTE') or die("Access Denied.");

interface FormatterInterface
{

    public function getIconClass();
    public function getBatchTreeElementObject();

}
