<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Editor\Snippet;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateContentEditorSnippetsRoutine implements RoutineInterface
{
    public function execute(Batch $batch)
    {
        $snippets = $batch->getObjectCollection('content_editor_snippet');

        if (!$snippets) {
            return;
        }

        foreach ($snippets->getSnippets() as $snippet) {
            if (!$snippet->getPublisherValidator()->skipItem()) {
                $pkg = null;
                if ($snippet->getPackage()) {
                    $pkg = \Package::getByHandle($snippet->getPackage());
                }
                $t = Snippet::add($snippet->getHandle(), $snippet->getNAme(), $pkg);
                if ($snippet->getIsActivated()) {
                    $t->activate();
                }
            }
        }
    }
}
