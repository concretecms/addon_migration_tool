<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Stack\FolderFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Stack\StackFolderTreeJsonFormatter;

/**
 * @Entity
 */
class StackFolder extends AbstractStack
{

    public function getType()
    {
        return 'folder';
    }

    public function getStackFormatter()
    {
        return new FolderFormatter($this);
    }
}
