<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\ClearBatchCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreatePageTemplatesCommand;

defined('C5_EXECUTE') or die("Access Denied.");

class CreatePageTemplatesRoutine extends AbstractRoutine
{

    public function getCommandClass()
    {
        return CreatePageTemplatesCommand::class;
    }

}
