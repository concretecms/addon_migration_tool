<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Concrete\Core\Support\Manager as CoreManager;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends CoreManager
{
    protected function createBlockTypeDriver()
    {
        return new BlockType();
    }

    protected function createAttributeKeyDriver()
    {
        return new AttributeKey();
    }

    protected function createJobDriver()
    {
        return new Job();
    }

    protected function createSinglePageDriver()
    {
        return new SinglePage();
    }

    protected function createThemeDriver()
    {
        return new Theme();
    }

    protected function createPageTemplateDriver()
    {
        return new PageTemplate();
    }

    protected function createPageTypeDriver()
    {
        return new PageType();
    }

    protected function createPageDriver()
    {
        return new Page();
    }

    protected function createAttributeKeyCategoryDriver()
    {
        return new AttributeKeyCategory();
    }

    public function createPageTypePublishTargetTypeDriver()
    {
        return new PageTypePublishTargetType();
    }

    public function createConversationEditorDriver()
    {
        return new ConversationEditor();
    }

    public function createConversationRatingTypeDriver()
    {
        return new ConversationRatingType();
    }

    public function createPageTypeComposerControlTypeDriver()
    {
        return new PageTypeComposerControlType();
    }

    public function __construct()
    {
        /*
         * This functionality isn't ready yet
         */
        /*
        $this->driver('feature');
        $this->driver('feature_category');
        $this->driver('gathering_data_source');
        $this->driver('gathering_item_template');
        */

        $this->driver('attribute_key_category');
        $this->driver('conversation_editor');
        $this->driver('conversation_rating_type');
        $this->driver('page_type_publish_target_type');
        $this->driver('page_type_composer_control_type');
        /*
        $this->driver('attribute_type');
        $this->driver('block_type_set');
        $this->driver('attribute_set');
        $this->driver('package');
        $this->driver('permission_access_entity_type');
        $this->driver('permission_key');
        $this->driver('workflow_type');
        $this->driver('stack');
        $this->driver('captcha');
        $this->driver('social_link');
        $this->driver('thumbnail_type');
        $this->driver('tree');
        */

        $this->driver('attribute_key');
        $this->driver('block_type');
        $this->driver('job');
        $this->driver('single_page');
        $this->driver('page_type');
        $this->driver('page_template');
        $this->driver('page');
        $this->driver('theme');
    }
}
