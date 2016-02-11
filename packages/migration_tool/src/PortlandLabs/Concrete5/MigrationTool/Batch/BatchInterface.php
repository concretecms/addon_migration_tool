<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch;

interface BatchInterface
{

    function getObjectCollections();
    function getObjectCollection($collection);

}
