<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\ClearBatchCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateTreesCommand;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateTreesRoutine extends AbstractRoutine
{

    public function getCommandClass()
    {
        return CreateTreesCommand::class;
    }

}
