<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Formatter;

defined('C5_EXECUTE') or die("Access Denied.");

class SinglePageFormatter extends AbstractFormatter
{

    public function getElement()
    {
        return 'page';
    }

    public function getPluralDisplayName()
    {
        return t('Single Pages');
    }
}

