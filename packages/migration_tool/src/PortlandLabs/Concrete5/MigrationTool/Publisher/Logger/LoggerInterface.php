<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger;

use Concrete\Core\Entity\User\User;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PublishableObject;

defined('C5_EXECUTE') or die("Access Denied.");

interface LoggerInterface
{

    function openLog(BatchInterface $batch, User $user = null);
    function closeLog(BatchInterface $batch);
    function logPublished(PublishableObject $object, $mixed);
    function logSkipped(PublishableObject $object);

}
