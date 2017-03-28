<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger;

use Concrete\Core\Entity\Site\Site;
use Concrete\Core\Entity\User\User;
use Concrete\Core\Permission\Access\Entity\Entity;
use Concrete\Core\Support\Facade\Facade;
use Doctrine\ORM\EntityManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Entry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Log;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\PublishCompleteEntry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\PublishStartedEntry;
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

    /**
     * @return Log
     */
    public function getLog()
    {
        return $this->log;
    }

    public function openLog(Batch $batch, User $user = null)
    {
        $log = new Log();
        $log->setUser($user);
        $log->setSite($batch->getSite());
        $log->setBatchId($batch->getId());
        $log->setBatchName($batch->getName());
        $this->entityManager->persist($log);
        $this->entityManager->flush();
        $this->logID = $log->getID();
    }

    public function closeLog(Batch $batch)
    {
        $this->log->setDateCompleted(new \DateTime());
        $this->entityManager->persist($this->log);
        $this->entityManager->flush();
    }

    public function logEntry(Entry $entry)
    {
        $entry->setLog($this->log);
        $this->log->getEntries()->add($entry);
        $this->entityManager->persist($this->log);
        $this->entityManager->flush();
    }

    public function logPublishStarted(LoggableInterface $object, $mixed = null)
    {
        $this->logEntry(new PublishStartedEntry($object->createPublisherLogObject($mixed)));
    }

    public function logPublishComplete(LoggableInterface $object, $mixed = null)
    {
        $lastEntry = $this->log->getEntries()->last();
        if ($lastEntry && get_class($lastEntry->getObject()) == get_class($object->createPublisherLogObject($mixed))) {

            // Remove the "creating item..." message because it's been successful.

            $lastEntry->setLog(null);
            $this->entityManager->remove($lastEntry);
            $this->entityManager->flush();
        }
        $this->logEntry(new PublishCompleteEntry($object->createPublisherLogObject($mixed)));
    }

    public function logSkipped(LoggableInterface $object)
    {
        $this->logEntry(new SkippedEntry($object->createPublisherLogObject()));
    }


}
