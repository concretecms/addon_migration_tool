<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Command;

use Concrete\Core\Application\Application;
use Concrete\Core\Foundation\Queue\Response\EnqueueItemsResponse;
use Doctrine\ORM\EntityManager;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchService;
use PortlandLabs\Concrete5\MigrationTool\Batch\Queue\QueueFactory;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Logger;

class PublishBatchCommandHandler
{
    /**
     * @var QueueFactory
     */
    protected $queueFactory;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var BatchService
     */
    protected $batchService;

    /**
     * @var Logger
     */
    protected $logger;

    public function __construct(Logger $logger, BatchService $batchService, Application $app, QueueFactory $queueFactory, EntityManager $entityManager)
    {
        $this->app = $app;
        $this->batchService = $batchService;
        $this->queueFactory = $queueFactory;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function handle(PublishBatchCommand $command)
    {
        $r = $this->entityManager->getRepository(Batch::class);
        $batch = $r->findOneById($command->getBatchId());
        $queue = $this->queueFactory->getPublisherQueue($batch);

        $u = new \User();
        $user = null;
        if ($u->isRegistered()) {
            $user = $u->getUserInfoObject()->getEntityObject();
        }

        $this->batchService->createImportNode($batch->getSite());
        $this->logger->openLog($batch, $user);

        $publishers = $this->app->make('migration/manager/publisher');
        foreach ($publishers->getDrivers() as $driver) {
            foreach ($driver->getPublisherCommands($batch, $this->logger) as $command) {
                $this->app->queueCommand($command);
            }
        }
        return new EnqueueItemsResponse($queue);
    }


}