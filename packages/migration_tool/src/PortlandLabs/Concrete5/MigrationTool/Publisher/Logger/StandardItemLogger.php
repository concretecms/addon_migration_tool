<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger;

use Doctrine\ORM\EntityManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardItemLogger implements ItemLoggerInterface
{

    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function logPublished(PublishableInterface $batchObject, $mixed)
    {

    }

    public function logSkipped(PublishableInterface $batchObject)
    {
        // TODO: Implement logSkipped() method.
    }

}
