<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Command;

use Concrete\Core\Application\Application;
use Concrete\Core\Foundation\Queue\Batch\Processor;
use Concrete\Core\Foundation\Queue\Response\EnqueueItemsResponse;
use Doctrine\ORM\EntityManager;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchService;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Logger;

class PublishBatchCommandHandler
{


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

    /**
     * @var Processor
     */
    protected $processor;

    public function __construct(Logger $logger, BatchService $batchService, Application $app, Processor $processor, EntityManager $entityManager)
    {
        $this->app = $app;
        $this->batchService = $batchService;
        $this->entityManager = $entityManager;
        $this->processor = $processor;
        $this->logger = $logger;
    }

    public function handle(PublishBatchCommand $command)
    {
        $r = $this->entityManager->getRepository(Batch::class);
        $batch = $r->findOneById($command->getBatchId());

        $u = new \User();
        $user = null;
        if ($u->isRegistered()) {
            $user = $u->getUserInfoObject()->getEntityObject();
        }

        $this->batchService->createImportNode($batch->getSite());
        $this->logger->openLog($batch, $user);

        $factory = new PublishBatchBatchProcessFactory($this->app, $this->logger);
        return $this->processor->process($factory, $batch);
    }


}