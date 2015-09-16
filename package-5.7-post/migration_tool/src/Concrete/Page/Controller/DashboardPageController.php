<?php

namespace Concrete\Package\MigrationTool\Page\Controller;
use Concrete\Core\Package\Package;

class DashboardPageController extends \Concrete\Core\Page\Controller\DashboardPageController
{

    public function on_start()
    {
        parent::on_start();
        $this->entityManager = Package::getByHandle('migration_tool')->getEntityManager();
    }

}
