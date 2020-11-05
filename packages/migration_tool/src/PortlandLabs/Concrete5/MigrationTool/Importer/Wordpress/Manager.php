<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress;

use Concrete\Core\Support\Manager as CoreManager;
use PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\Element\Page;
use PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\Element\Tree;
use PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\Element\User;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends CoreManager
{
    public function createPageDriver()
    {
        return new Page();
    }

    public function createTreeDriver()
    {
        return new Tree();
    }

    public function createUserDriver()
    {
        return new User();
    }

    public function __construct()
    {
        $this->driver('page');
        $this->driver('tree');
        $this->driver('user');
    }
}
