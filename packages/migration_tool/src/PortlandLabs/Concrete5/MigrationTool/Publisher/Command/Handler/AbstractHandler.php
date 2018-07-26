<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler;


use Concrete\Core\Application\Application;
use Doctrine\ORM\EntityManager;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Log;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\PublisherCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Logger;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\SystemLogHandler;

abstract class AbstractHandler
{

    /**
     * @param BatchInterface $batch
     * @param Logger $logger
     * @return mixed
     */
    abstract public function execute(BatchInterface $batch, LoggerInterface $logger);

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var PublisherCommand
     */
    protected $command;

    public function __construct(Logger $logger, Application $app, EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->app = $app;
    }

    public function handle(PublisherCommand $command)
    {
        $batch = $this->getBatch($command);
        $logger = $this->getLogger($command);

        $coreLogger = $this->app->make('log/exceptions');
        $coreLogger->pushHandler(new SystemLogHandler($logger));

        $this->command = $command;
        $this->execute($batch, $logger);

        $coreLogger->popHandler();
    }

    public function getBatch(PublisherCommand $command)
    {
        $r = $this->entityManager->getRepository(Batch::class);
        return $r->findOneById($command->getBatchId());
    }

    public function getLogger(PublisherCommand $command)
    {
        $log = $this->entityManager->getRepository(Log::class)
            ->findOneById($command->getLogId());
        $this->logger->setLog($log);
        return $this->logger;
    }


}
