<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Formatter;

defined('C5_EXECUTE') or die("Access Denied.");

class JobSetFormatter extends AbstractFormatter
{

    public function getPluralDisplayName()
    {
        return t('Job Sets');
    }
}

