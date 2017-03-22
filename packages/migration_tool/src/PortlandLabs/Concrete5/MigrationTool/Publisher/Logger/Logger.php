<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger;

use Concrete\Core\Entity\User\User;
use Concrete\Core\Permission\Access\Entity\Entity;
use Concrete\Core\Support\Facade\Facade;
use Doctrine\ORM\EntityManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PublishableObject;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Entry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Log;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\PublishedEntry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\SkippedEntry;

defined('C5_EXECUTE') or die("Access Denied.");

class Logger implements LoggerInterface
{

    protected $entityManager;
    protected $logID;
    protected $log;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __sleep()
    {
        return array('logID');
    }

    public function __wakeup()
    {
        $app = Facade::getFacadeApplication();
        $this->entityManager = $app->make(EntityManagerInterface::class);
        $this->log = $this->entityManager->getRepository(Log::class)->findOneById($this->logID);
    }

    public function openLog(BatchInterface $batch, User $user = null)
    {
        $log = new Log();
        $log->setUser($user);
        $this->entityManager->persist($log);
        $this->entityManager->flush();
        $this->logID = $log->getID();
    }

    public function closeLog(BatchInterface $batch)
    {
        $this->log->setDateCompleted(new \DateTime());
        $this->entityManager->persist($this->log);
        $this->entityManager->flush();
    }

    protected function logEntry(Entry $entry)
    {
        $entry->setLog($this->log);
        $this->log->getEntries()->add($entry);
    }

    public function logPublished(PublishableObject $object, $mixed)
    {
        $object = clone $object;
        $this->logEntry(new PublishedEntry($object));
    }

    public function logSkipped(PublishableObject $object)
    {
        $object = clone $object;
        $this->logEntry(new SkippedEntry($object));
    }


}
