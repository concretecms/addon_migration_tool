<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Formatter;

defined('C5_EXECUTE') or die("Access Denied.");

class BlockTypeSetFormatter extends AbstractFormatter
{

    public function getPluralDisplayName()
    {
        return t('Block Type Sets');
    }
}

