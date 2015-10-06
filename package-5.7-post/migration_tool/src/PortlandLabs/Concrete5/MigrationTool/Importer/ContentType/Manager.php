<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\ContentType;

use Concrete\Core\Support\Manager as CoreManager;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\AttributeType;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\AttributeKeyCategory;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\BlockTypeSet;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\ConversationEditor;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\ConversationFlagType;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\ConversationRatingType;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\Page;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\PageTemplate;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\PageTypeComposerControlType;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\PageTypeComposerOutputControlType;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\PageTypePublishTargetType;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\SinglePage;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type\ThumbnailType;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends CoreManager
{

    public function createPageDriver()
    {
        return new Page();
    }

    public function createAttributeKeyDriver()
    {
        return new AttributeKey();
    }


    public function createSinglePagedriver()
    {
        return new SinglePage();
    }

    public function createPageTemplateDriver()
    {
        return new PageTemplate();
    }

    public function createBlockTypeDriver()
    {
        return new BlockType();
    }

    public function createConversationEditorDriver()
    {
        return new ConversationEditor();
    }

    public function createConversationFlagTypeDriver()
    {
        return new ConversationFlagType();
    }

    public function createConversationRatingTypeDriver()
    {
        return new ConversationRatingType();
    }

    public function createAttributeKeyCategoryDriver()
    {
        return new AttributeKeyCategory();
    }

    public function createAttributeTypeDriver()
    {
        return new AttributeType();
    }

    public function createThumbnailTypeDriver()
    {
        return new ThumbnailType();
    }

    public function createBlockTypeSetDriver()
    {
        return new BlockTypeSet();
    }

    public function createPageTypePublishTargetTypeDriver()
    {
        return new PageTypePublishTargetType();
    }

    public function createPageTypeComposerControlTypeDriver()
    {
        return new PageTypeComposerControlType();
    }


    public function __construct()
    {
        $this->driver('thumbnail_type');
        $this->driver('page_type_publish_target_type');
        $this->driver('page_type_composer_control_type');
        $this->driver('attribute_type');
        $this->driver('attribute_key_category');
        $this->driver('conversation_editor');
        $this->driver('conversation_flag_type');
        $this->driver('conversation_rating_type');
        $this->driver('attribute_key');
        $this->driver('block_type');
        $this->driver('block_type_set');
        $this->driver('single_page');
        $this->driver('page');
        $this->driver('page_template');
    }
}
