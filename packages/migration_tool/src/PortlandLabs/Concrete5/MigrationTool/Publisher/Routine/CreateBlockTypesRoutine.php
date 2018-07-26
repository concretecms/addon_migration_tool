<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\ClearBatchCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateBlockTypesCommand;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateBlockTypesRoutine extends AbstractRoutine
{

    public function getCommandClass()
    {
        return CreateBlockTypesCommand::class;
    }

}
