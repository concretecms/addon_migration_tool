<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Middleware;

use Concrete\Core\Application\Application;
use Doctrine\ORM\EntityManager;
use League\Tactician\Middleware;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Log;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\PublisherCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Logger;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\SystemLogHandler;

class PublisherExceptionHandlingMiddleware implements Middleware
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Logger
     */
    protected $batchLoggingService;

    public function __construct(Logger $batchLoggingService, Application $app, EntityManager $entityManager)
    {
        $this->batchLoggingService = $batchLoggingService;
        $this->entityManager = $entityManager;
        $this->app = $app;
    }

    public function execute($command, callable $next)
    {

        /**
         * @var $command PublisherCommand
         */
        $log = $this->entityManager->getRepository(Log::class)
            ->findOneById($command->getLogId());
        $this->batchLoggingService->setLog($log);

        $coreLogger = $this->app->make('log/exceptions');

        $coreLogger->pushHandler(new SystemLogHandler($this->batchLoggingService));

        $return = $next($command);

        $coreLogger->popHandler();

        return $return;

    }
}