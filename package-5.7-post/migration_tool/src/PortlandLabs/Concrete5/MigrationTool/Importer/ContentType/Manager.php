<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\ContentType;

use Concrete\Core\Support\Manager as CoreManager;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\Page;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\PageTemplate;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\SinglePage;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends CoreManager
{

    public function createPageDriver()
    {
        return new Page();
    }

    public function createAttributeKeyDriver()
    {
        return new AttributeKey();
    }


    public function createSinglePagedriver()
    {
        return new SinglePage();
    }

    public function createPageTemplateDriver()
    {
        return new PageTemplate();
    }

    public function createBlockTypeDriver()
    {
        return new BlockType();
    }

    public function __construct()
    {
        $this->driver('attribute_key');
        $this->driver('block_type');
        $this->driver('single_page');
        $this->driver('page');
        $this->driver('page_template');
    }
}
