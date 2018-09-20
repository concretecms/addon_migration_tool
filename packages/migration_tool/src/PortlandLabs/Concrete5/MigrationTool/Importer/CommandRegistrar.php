<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer;

use Concrete\Core\Application\Application;
use PortlandLabs\Concrete5\MigrationTool\Batch\Command\MapContentTypesCommand;
use PortlandLabs\Concrete5\MigrationTool\Batch\Command\MapContentTypesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Batch\Command\PublishBatchCommand;
use PortlandLabs\Concrete5\MigrationTool\Batch\Command\PublishBatchCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Batch\Command\TransformContentTypesCommand;
use PortlandLabs\Concrete5\MigrationTool\Batch\Command\TransformContentTypesCommandHandler;
use PortlandLabs\Concrete5\MigrationTool\Batch\Command\NormalizePagePathsCommand;
use PortlandLabs\Concrete5\MigrationTool\Batch\Command\NormalizePagePathsCommandHandler;
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
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateUserCommand;
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
        $locator = $this->app->getCommandDispatcher();
        $locator->registerCommand($this->app->make(MapContentTypesCommandHandler::class), MapContentTypesCommand::class);
        $locator->registerCommand($this->app->make(TransformContentTypesCommandHandler::class), TransformContentTypesCommand::class);
        $locator->registerCommand($this->app->make(PublishBatchCommandHandler::class), PublishBatchCommand::class);
        $locator->registerCommand($this->app->make(NormalizePagePathsCommandHandler::class), NormalizePagePathsCommand::class);

        // Publishing
        $locator->registerCommand($this->app->make(ClearBatchCommandHandler::class), ClearBatchCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreatePackagesCommandHandler::class), CreatePackagesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateGroupsCommandHandler::class), CreateGroupsCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateWorkflowTypesCommandHandler::class), CreateWorkflowTypesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateContentEditorSnippetsCommandHandler::class), CreateContentEditorSnippetsCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateWorkflowProgressCategoriesCommandHandler::class), CreateWorkflowProgressCategoriesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateBannedWordsCommandHandler::class), CreateBannedWordsCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateConfigValuesCommandHandler::class), CreateConfigValuesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateCaptchaLibrariesCommandHandler::class), CreateCaptchaLibrariesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateTreesCommandHandler::class), CreateTreesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateThemesCommandHandler::class), CreateThemesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateThumbnailTypesCommandHandler::class), CreateThumbnailTypesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateSocialLinksCommandHandler::class), CreateSocialLinksCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateJobsCommandHandler::class), CreateJobsCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateJobSetsCommandHandler::class), CreateJobSetsCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreatePageTypePublishTargetTypesCommandHandler::class), CreatePageTypePublishTargetTypesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreatePageTypeComposerControlTypesCommandHandler::class), CreatePageTypeComposerControlTypesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateConversationDataCommandHandler::class), CreateConversationDataCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreatePermissionCategoriesCommandHandler::class), CreatePermissionCategoriesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreatePermissionAccessEntityTypesCommandHandler::class), CreatePermissionAccessEntityTypesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreatePermissionsCommandHandler::class), CreatePermissionsCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateAttributeTypesCommandHandler::class), CreateAttributeTypesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateAttributeCategoriesCommandHandler::class), CreateAttributeCategoriesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateAttributesCommandHandler::class), CreateAttributesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateAttributeSetsCommandHandler::class), CreateAttributeSetsCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateExpressEntitiesCommandHandler::class), CreateExpressEntitiesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateExpressEntityDataCommandHandler::class), CreateExpressEntityDataCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateUserCommandHandler::class), CreateUserCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateExpressEntryCommandHandler::class), CreateExpressEntryCommand::class, 'publish');
        $locator->registerCommand($this->app->make(AssociateExpressEntryCommandHandler::class), AssociateExpressEntryCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateBlockTypesCommandHandler::class), CreateBlockTypesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateBlockTypeSetsCommandHandler::class), CreateBlockTypeSetsCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreatePageTemplatesCommandHandler::class), CreatePageTemplatesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreatePageTypesCommandHandler::class), CreatePageTypesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateStackStructureCommandHandler::class), CreateStackStructureCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateSinglePageStructureCommandHandler::class), CreateSinglePageStructureCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreatePageStructureCommandHandler::class), CreatePageStructureCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreatePageFeedsCommandHandler::class), CreatePageFeedsCommand::class, 'publish');
        $locator->registerCommand($this->app->make(PublishStackContentCommandHandler::class), PublishStackContentCommand::class, 'publish');
        $locator->registerCommand($this->app->make(PublishPageContentCommandHandler::class), PublishSinglePageContentCommand::class, 'publish');
        $locator->registerCommand($this->app->make(PublishPageContentCommandHandler::class), PublishPageContentCommand::class, 'publish');
        $locator->registerCommand($this->app->make(CreateSitesCommandHandler::class), CreateSitesCommand::class, 'publish');
        $locator->registerCommand($this->app->make(ClosePublisherLogCommandHandler::class), ClosePublisherLogCommand::class, 'publish');

    }
}