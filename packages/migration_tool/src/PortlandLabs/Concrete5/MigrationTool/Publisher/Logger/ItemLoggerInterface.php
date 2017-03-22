<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger;

use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;

defined('C5_EXECUTE') or die("Access Denied.");

interface ItemLoggerInterface
{

    function logPublished(PublishableInterface $batchObject, $mixed);

    function logSkipped(PublishableInterface $batchObject);

}
