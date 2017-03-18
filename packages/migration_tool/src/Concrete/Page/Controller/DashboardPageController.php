<?php
namespace Concrete\Package\MigrationTool\Page\Controller;

use Concrete\Core\Package\Package;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

class DashboardPageController extends \Concrete\Core\Page\Controller\DashboardPageController
{

    /**
     * @param $id
     * @return Batch
     */
    protected function getBatch($id)
    {
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
        $batch = $r->findOneById($id);
        return $batch;
    }
}
