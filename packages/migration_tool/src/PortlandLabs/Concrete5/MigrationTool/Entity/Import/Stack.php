<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Stack\StackFormatter;

/**
 * @Entity
 */
class Stack extends AbstractStack
{
    public function getType()
    {
        return 'stack';
    }

    public function getStackFormatter()
    {
        return new StackFormatter($this);
    }
}
