<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\SinglePageFormatter;

/**
 * @Entity
 */
class SinglePageObjectCollection extends PageObjectCollection
{
    public function getType()
    {
        return 'single_page';
    }

    public function getFormatter()
    {
        return new SinglePageFormatter($this);
    }
}
