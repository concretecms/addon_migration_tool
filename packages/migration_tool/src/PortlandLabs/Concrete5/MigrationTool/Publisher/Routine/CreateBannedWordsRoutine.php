<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\ClearBatchCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateBannedWordsCommand;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateBannedWordsRoutine extends AbstractRoutine
{

    public function getCommandClass()
    {
        return CreateBannedWordsCommand::class;
    }

}
