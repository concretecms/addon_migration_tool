<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\ClearBatchCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateBlockTypeSetsCommand;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateBlockTypeSetsRoutine extends AbstractRoutine
{

    public function getCommandClass()
    {
        return CreateBlockTypeSetsCommand::class;
    }

}
