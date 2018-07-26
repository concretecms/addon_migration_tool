<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\ClearBatchCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateCaptchaLibrariesCommand;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateCaptchaLibrariesRoutine extends AbstractRoutine
{

    public function getCommandClass()
    {
        return CreateCaptchaLibrariesCommand::class;
    }

}
