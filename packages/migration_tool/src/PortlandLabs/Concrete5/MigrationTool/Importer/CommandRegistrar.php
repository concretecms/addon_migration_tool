<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer;

use Concrete\Core\Application\Application;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Command\MapContentTypesCommand;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Command\MapContentTypesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Command\PublishBatchCommand;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Command\PublishBatchCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Command\TransformContentTypesCommand;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Command\TransformContentTypesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\ClearBatchCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateContentEditorSnippetsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateGroupsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreatePackagesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateWorkflowProgressCategoriesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateWorkflowTypesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\ClearBatchCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateContentEditorSnippetsCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateGroupsCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreatePackagesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateWorkflowProgressCategoriesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateWorkflowTypesCommandHandler;

class CommandRegistrar
{

    /**
     * @var Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function register()
    {
        $locator = $this->app->getCommandBus()->getCommandLocator();
        $locator->addHandler($this->app->make(MapContentTypesCommandHandler::class), MapContentTypesCommand::class);
        $locator->addHandler($this->app->make(TransformContentTypesCommandHandler::class), TransformContentTypesCommand::class);
        $locator->addHandler($this->app->make(PublishBatchCommandHandler::class), PublishBatchCommand::class);

        // Publishing
        $locator->addHandler($this->app->make(ClearBatchCommandHandler::class), ClearBatchCommand::class);
        $locator->addHandler($this->app->make(CreatePackagesCommandHandler::class), CreatePackagesCommand::class);
        $locator->addHandler($this->app->make(CreateGroupsCommandHandler::class), CreateGroupsCommand::class);
        $locator->addHandler($this->app->make(CreateWorkflowTypesCommandHandler::class), CreateWorkflowTypesCommand::class);
        $locator->addHandler($this->app->make(CreateContentEditorSnippetsCommandHandler::class), CreateContentEditorSnippetsCommand::class);
        $locator->addHandler($this->app->make(CreateWorkflowProgressCategoriesCommandHandler::class), CreateWorkflowProgressCategoriesCommand::class);




    }
}
