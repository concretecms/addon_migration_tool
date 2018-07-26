<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\ClearBatchCommand;

defined('C5_EXECUTE') or die("Access Denied.");

class CreatePackagesRoutine extends AbstractRoutine
{

    public function getCommandClass()
    {
        return ClearBatchCommand::class;
    }

}
