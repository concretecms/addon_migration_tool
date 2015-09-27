<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\ContentType;

use Concrete\Core\Support\Manager as CoreManager;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\Page;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\PageTemplate;
defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends CoreManager
{

    public function createPageDriver()
    {
        return new Page();
    }

    public function createPageTemplateDriver()
    {
        return new PageTemplate();
    }
    public function __construct()
    {
        $this->driver('page');
        $this->driver('page_template');
    }
}
