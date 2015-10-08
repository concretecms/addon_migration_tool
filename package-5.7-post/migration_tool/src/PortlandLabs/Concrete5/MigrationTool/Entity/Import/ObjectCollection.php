<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

/**
 * @Entity
 * @Table(name="MigrationImportObjectCollections")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="type", type="string")
 * @DiscriminatorMap( {
 * "page" = "PageObjectCollection",
 * "thumbnail_type" = "ThumbnailTypeObjectCollection",
 * "page_type_publish_target_type" = "\PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\PublishTargetTypeObjectCollection",
 * "page_type_composer_control_type" = "\PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\ComposerControlTypeObjectCollection",
 * "conversation_editor" = "\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\EditorObjectCollection",
 * "conversation_flag_type" = "\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\FlagTypeObjectCollection",
 * "conversation_rating_type" = "\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\RatingTypeObjectCollection",
 * "workflow_progress_category" = "\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow\ProgressCategoryObjectCollection",
 * "workflow_type" = "\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow\TypeObjectCollection",
 * "page_template" = "PageTemplateObjectCollection",
 * "permission_category" = "\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\CategoryObjectCollection",
 * "permission_access_entity_type" = "\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\AccessEntityTypeObjectCollection",
 * "attribute_key_category" = "\PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKeyCategoryObjectCollection",
 * "attribute_key" = "\PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKeyObjectCollection",
 * "banned_word" = "BannedWordObjectCollection",
 * "captcha" = "CaptchaObjectCollection",
 * "social_link" = "SocialLinkObjectCollection",
 * "theme" = "ThemeObjectCollection",
 * "single_page" = "SinglePageObjectCollection",
 * "job" = "JobObjectCollection",
 * "config_value" = "ConfigValueObjectCollection",
 * "content_editor_snippet" = "ContentEditorSnippetObjectCollection",
 * "package" = "PackageObjectCollection",
 * "page_feed" = "PageFeedObjectCollection",
 * "job_set" = "JobSetObjectCollection",
 * "block_type_set" = "BlockTypeSetObjectCollection",
 * "attribute_set" = "AttributeSetObjectCollection",
 * "attribute_type" = "AttributeTypeObjectCollection",
 * "block_type" = "BlockTypeObjectCollection"
 * } )
 */
abstract class ObjectCollection
{

    /**
     * @Id @Column(type="guid")
     * @GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    abstract public function hasRecords();

    abstract public function getFormatter();

    abstract public function getTreeFormatter();

    abstract public function getType();

    abstract public function getRecords();

    abstract public function getRecordValidator();



}
