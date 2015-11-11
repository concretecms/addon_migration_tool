<?php

namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Concrete\Core\Support\Manager as CoreManager;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends CoreManager
{

    protected function createBlockTypeDriver()
    {
        return new BlockType();
    }

    protected function createAttributeKeyDriver()
    {
        return new AttributeKey();
    }

    public function __construct()
    {
        $this->driver('attribute_key');
        $this->driver('block_type');
    }
}
