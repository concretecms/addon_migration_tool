<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Command;

use Concrete\Core\Foundation\Command\AbstractSynchronousBus;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Middleware\PublisherExceptionHandlingMiddleware;

class PublishCommandBus extends AbstractSynchronousBus
{

    public static function getHandle()
    {
        return 'publish';
    }

    public function getMiddleware()
    {
        return [
            $this->app->make(PublisherExceptionHandlingMiddleware::class)
        ];
    }

}