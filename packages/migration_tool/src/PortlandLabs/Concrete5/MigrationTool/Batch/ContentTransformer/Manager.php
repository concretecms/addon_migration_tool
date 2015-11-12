<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer;

use Concrete\Core\Support\Manager as CoreManager;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Type\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Type\BlockType;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends CoreManager
{

    protected function createAttributeDriver()
    {
        return new Attribute();
    }

    protected function createBlockTypeDriver()
    {
        return new BlockType();
    }

    public function __construct($app)
    {
        parent::__construct($app);
        $this->driver('attribute');
        $this->driver('block_type');
    }
}
