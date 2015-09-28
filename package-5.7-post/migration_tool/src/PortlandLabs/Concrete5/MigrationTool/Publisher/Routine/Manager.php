<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Support\Manager as CoreManager;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends CoreManager
{

    public function createCreatePageTemplatesDriver()
    {
        return new CreatePageTemplatesRoutine();
    }

    public function createCreateBlockTypesDriver()
    {
        return new CreateBlockTypesRoutine();
    }

    public function createClearBatchDriver()
    {
        return new ClearBatchRoutine();
    }

    public function createPublishPageContentDriver()
    {
        return new PublishPageContentRoutine();
    }

    public function createCreatePageStructureDriver()
    {
        return new CreatePageStructureRoutine();
    }

    public function createCreateSinglePageStructureDriver()
    {
        return new CreateSinglePageStructureRoutine();
    }

    public function __construct()
    {
        $this->driver('clear_batch');
        $this->driver('create_block_types');
        $this->driver('create_single_page_structure');
        $this->driver('create_page_templates');
        $this->driver('create_page_structure');
        $this->driver('publish_page_content');
    }
}
