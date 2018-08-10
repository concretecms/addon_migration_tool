<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;

interface ValidatorResultInterface
{

    /**
     * @return MessageCollection
     */
    public function getMessages();


}
