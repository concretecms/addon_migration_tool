<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\ClearBatchCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateThemesCommand;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateThemesRoutine extends AbstractRoutine
{

    public function getCommandClass()
    {
        return CreateThemesCommand::class;
    }

}
