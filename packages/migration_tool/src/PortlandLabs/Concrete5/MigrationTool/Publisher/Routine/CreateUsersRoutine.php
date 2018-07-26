<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateUserCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

class CreateUsersRoutine implements RoutineInterface
{

    public function getPublisherCommands(BatchInterface $batch, LoggerInterface $logger)
    {
        $events = $batch->getObjectCollection('user');

        if (!$events) {
            return array();
        }

        $commands = array();
        foreach ($events->getUsers() as $user) {
            if (!$user->getPublisherValidator()->skipItem()) {
                $command = new CreateUserCommand($batch, $logger, $user->getId());
                $commands[] = $command;
            }
        }

        return $commands;

    }

}
