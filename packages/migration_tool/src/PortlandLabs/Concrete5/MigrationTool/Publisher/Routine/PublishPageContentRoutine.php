<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Type\Composer\FormLayoutSetControl;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class PublishPageContentRoutine extends AbstractPageRoutine
{

    public function getPageRoutineAction($page)
    {
        return new PublishPageContentRoutineAction($page);
    }

}
