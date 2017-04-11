<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Block;

use Concrete\Core\Support\Manager as CoreManager;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends CoreManager
{
    public function driver($driver = null)
    {
        $method = 'create'.camelcase($driver).'Driver';
        if ($driver && !isset($this->customCreators[$driver]) && !method_exists($this, $method)) {
            return null;
        }

        return parent::driver($driver);
    }

    public function createSlideshowDriver()
    {
        return new LegacySlideshowValidator();
    }
}
