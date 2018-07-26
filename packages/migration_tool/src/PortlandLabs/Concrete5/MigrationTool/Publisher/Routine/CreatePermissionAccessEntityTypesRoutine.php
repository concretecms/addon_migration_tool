<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\ClearBatchCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateGroupsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateJobSetsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreatePermissionAccessEntityTypesCommand;

defined('C5_EXECUTE') or die("Access Denied.");

class CreatePermissionAccessEntityTypesRoutine extends AbstractRoutine
{

    public function getCommandClass()
    {
        return CreatePermissionAccessEntityTypesCommand::class;
    }

}
