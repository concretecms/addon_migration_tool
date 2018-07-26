<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer;

use Concrete\Core\Application\Application;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Command\MapContentTypesCommand;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Command\MapContentTypesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Command\PublishBatchCommand;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Command\PublishBatchCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Command\TransformContentTypesCommand;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Command\TransformContentTypesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\AssociateExpressEntryCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\ClearBatchCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\ClosePublisherLogCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateAttributeCategoriesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateAttributesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateAttributeSetsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateAttributeTypesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateBannedWordsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateBlockTypesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateBlockTypeSetsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateCaptchaLibrariesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateConfigValuesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateContentEditorSnippetsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateConversationDataCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateExpressEntitiesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateExpressEntityDataCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateExpressEntryCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateGroupsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateJobsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateJobSetsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreatePackagesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreatePageFeedsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreatePageStructureCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreatePageTemplatesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreatePageTypeComposerControlTypesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreatePageTypePublishTargetTypesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreatePageTypesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreatePermissionAccessEntityTypesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreatePermissionCategoriesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreatePermissionsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateSinglePageStructureCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateSitesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateSocialLinksCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateStackStructureCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateThemesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateThumbnailTypesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateTreesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateWorkflowProgressCategoriesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateWorkflowTypesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\AssociateExpressEntryCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\ClearBatchCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\ClosePublisherLogCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateAttributeCategoriesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateAttributesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateAttributeSetsCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateAttributeTypesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateBannedWordsCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateBlockTypesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateBlockTypeSetsCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateCaptchaLibrariesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateConfigValuesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateContentEditorSnippetsCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateConversationDataCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateExpressEntitiesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateExpressEntityDataCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateExpressEntryCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateGroupsCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateJobsCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateJobSetsCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreatePackagesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreatePageFeedsCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreatePageStructureCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreatePageTemplatesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreatePageTypeComposerControlTypesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreatePageTypePublishTargetTypesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreatePageTypesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreatePermissionAccessEntityTypesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreatePermissionCategoriesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreatePermissionsCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateSinglePageStructureCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateSitesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateSocialLinksCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateStackStructureCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateThemesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateThumbnailTypesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateTreesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateUserCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateWorkflowProgressCategoriesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\CreateWorkflowTypesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\PublishPageContentCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\PublishStackContentCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\PublishPageContentCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\PublishSinglePageContentCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\PublishStackContentCommand;

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
        $locator->addHandler($this->app->make(CreateBannedWordsCommandHandler::class), CreateBannedWordsCommand::class);
        $locator->addHandler($this->app->make(CreateConfigValuesCommandHandler::class), CreateConfigValuesCommand::class);
        $locator->addHandler($this->app->make(CreateCaptchaLibrariesCommandHandler::class), CreateCaptchaLibrariesCommand::class);
        $locator->addHandler($this->app->make(CreateTreesCommandHandler::class), CreateTreesCommand::class);
        $locator->addHandler($this->app->make(CreateThemesCommandHandler::class), CreateThemesCommand::class);
        $locator->addHandler($this->app->make(CreateThumbnailTypesCommandHandler::class), CreateThumbnailTypesCommand::class);
        $locator->addHandler($this->app->make(CreateSocialLinksCommandHandler::class), CreateSocialLinksCommand::class);
        $locator->addHandler($this->app->make(CreateJobsCommandHandler::class), CreateJobsCommand::class);
        $locator->addHandler($this->app->make(CreateJobSetsCommandHandler::class), CreateJobSetsCommand::class);
        $locator->addHandler($this->app->make(CreatePageTypePublishTargetTypesCommandHandler::class), CreatePageTypePublishTargetTypesCommand::class);
        $locator->addHandler($this->app->make(CreatePageTypeComposerControlTypesCommandHandler::class), CreatePageTypeComposerControlTypesCommand::class);
        $locator->addHandler($this->app->make(CreateConversationDataCommandHandler::class), CreateConversationDataCommand::class);
        $locator->addHandler($this->app->make(CreatePermissionCategoriesCommandHandler::class), CreatePermissionCategoriesCommand::class);
        $locator->addHandler($this->app->make(CreatePermissionAccessEntityTypesCommandHandler::class), CreatePermissionAccessEntityTypesCommand::class);
        $locator->addHandler($this->app->make(CreatePermissionsCommandHandler::class), CreatePermissionsCommand::class);
        $locator->addHandler($this->app->make(CreateAttributeTypesCommandHandler::class), CreateAttributeTypesCommand::class);
        $locator->addHandler($this->app->make(CreateAttributeCategoriesCommandHandler::class), CreateAttributeCategoriesCommand::class);
        $locator->addHandler($this->app->make(CreateAttributesCommandHandler::class), CreateAttributesCommand::class);
        $locator->addHandler($this->app->make(CreateAttributeSetsCommandHandler::class), CreateAttributeSetsCommand::class);
        $locator->addHandler($this->app->make(CreateExpressEntitiesCommandHandler::class), CreateExpressEntitiesCommand::class);
        $locator->addHandler($this->app->make(CreateExpressEntityDataCommandHandler::class), CreateExpressEntityDataCommand::class);
        $locator->addHandler($this->app->make(CreateUserCommandHandler::class), CreateAttributeCategoriesCommand::class);
        $locator->addHandler($this->app->make(CreateExpressEntryCommandHandler::class), CreateExpressEntryCommand::class);
        $locator->addHandler($this->app->make(AssociateExpressEntryCommandHandler::class), AssociateExpressEntryCommand::class);
        $locator->addHandler($this->app->make(CreateBlockTypesCommandHandler::class), CreateBlockTypesCommand::class);
        $locator->addHandler($this->app->make(CreateBlockTypeSetsCommandHandler::class), CreateBlockTypeSetsCommand::class);
        $locator->addHandler($this->app->make(CreatePageTemplatesCommandHandler::class), CreatePageTemplatesCommand::class);
        $locator->addHandler($this->app->make(CreatePageTypesCommandHandler::class), CreatePageTypesCommand::class);
        $locator->addHandler($this->app->make(CreateStackStructureCommandHandler::class), CreateStackStructureCommand::class);
        $locator->addHandler($this->app->make(CreateSinglePageStructureCommandHandler::class), CreateSinglePageStructureCommand::class);
        $locator->addHandler($this->app->make(CreatePageStructureCommandHandler::class), CreatePageStructureCommand::class);
        $locator->addHandler($this->app->make(CreatePageFeedsCommandHandler::class), CreatePageFeedsCommand::class);
        $locator->addHandler($this->app->make(PublishStackContentCommandHandler::class), PublishStackContentCommand::class);
        $locator->addHandler($this->app->make(PublishPageContentCommandHandler::class), PublishSinglePageContentCommand::class);
        $locator->addHandler($this->app->make(PublishPageContentCommandHandler::class), PublishPageContentCommand::class);
        $locator->addHandler($this->app->make(CreateSitesCommandHandler::class), CreateSitesCommand::class);
        $locator->addHandler($this->app->make(ClosePublisherLogCommandHandler::class), ClosePublisherLogCommand::class);

    }
}