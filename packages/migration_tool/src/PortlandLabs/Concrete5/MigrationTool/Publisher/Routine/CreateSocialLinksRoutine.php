<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\ClearBatchCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateGroupsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateSocialLinksCommand;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateSocialLinksRoutine extends AbstractRoutine
{

    public function getCommandClass()
    {
        return CreateSocialLinksCommand::class;
    }

}
