<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer;

use Concrete\Core\Support\Manager as CoreManager;

use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\AttributeSet;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\AttributeType;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\AttributeKeyCategory;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\BannedWord;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\BlockTypeSet;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\Captcha;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\ConfigValue;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\ContentEditorSnippet;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\ConversationEditor;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\ConversationFlagType;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\ConversationRatingType;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\Job;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\JobSet;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\Package;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\Page;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\PageFeed;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\PageTemplate;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\PageType;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\PageTypeComposerControlType;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\PageTypeComposerOutputControlType;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\PageTypePublishTargetType;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\PermissionAccessEntityType;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\PermissionKey;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\PermissionKeyCategory;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\SinglePage;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\SocialLink;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\Stack;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\Theme;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\ThumbnailType;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\Tree;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\WorkflowProgressCategory;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\WorkflowType;
use PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIFParser;
use PortlandLabs\Concrete5\MigrationTool\Importer\Parser\WordpressParser;

defined('C5_EXECUTE') or die("Access Denied.");

class FormatManager extends CoreManager
{

    public function createConcrete5Driver()
    {
        return new CIFParser();
    }

    public function createWordpressDriver()
    {
        return new WordpressParser();
    }

    public function __construct()
    {
        $this->driver('concrete5');
        $this->driver('wordpress');
    }

}
