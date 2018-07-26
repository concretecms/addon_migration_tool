<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\ClearBatchCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateGroupsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateJobSetsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreatePageTypePublishTargetTypesCommand;

defined('C5_EXECUTE') or die("Access Denied.");

class CreatePageTypePublishTargetTypesRoutine extends AbstractRoutine
{

    public function getCommandClass()
    {
        return CreatePageTypePublishTargetTypesCommand::class;
    }

}
