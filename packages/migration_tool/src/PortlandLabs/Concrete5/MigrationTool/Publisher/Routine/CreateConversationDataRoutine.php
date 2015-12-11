<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Conversation\Editor\Editor;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateConversationDataRoutine extends AbstractPageRoutine
{
    public function execute(Batch $batch)
    {
        $editors = $batch->getObjectCollection('conversation_editor');

        if ($editors) {
            foreach ($editors->getEditors() as $editor) {
                if (!$editor->getPublisherValidator()->skipItem()) {
                    $pkg = null;
                    if ($editor->getPackage()) {
                        $pkg = \Package::getByHandle($editor->getPackage());
                    }
                    $ce = Editor::add($editor->getHandle(),
                        $editor->getName(), $pkg);
                    if ($editor->getIsActive()) {
                        $ce->activate();
                    }
                }
            }
        }

        $types = $batch->getObjectCollection('conversation_flag_type');

        if ($types) {
            foreach ($types->getTypes() as $type) {
                if (!$type->getPublisherValidator()->skipItem()) {
                    $pkg = null;
                    if ($type->getPackage()) {
                        $pkg = \Package::getByHandle($type->getPackage());
                    }
                    $ce = \Concrete\Core\Conversation\FlagType\FlagType::add($type->getHandle());
                }
            }
        }

        $types = $batch->getObjectCollection('conversation_rating_type');

        if ($types) {
            foreach ($types->getTypes() as $type) {
                if (!$type->getPublisherValidator()->skipItem()) {
                    $pkg = null;
                    if ($type->getPackage()) {
                        $pkg = \Package::getByHandle($type->getPackage());
                    }
                    \Concrete\Core\Conversation\Rating\Type::add(
                        $type->getHandle(), $type->getName(), $type->getPoints(),
                        $pkg
                    );
                }
            }
        }
    }
}
