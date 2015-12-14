<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Template;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreatePageTemplatesRoutine implements RoutineInterface
{
    public function execute(Batch $batch)
    {
        $templates = $batch->getObjectCollection('page_template');

        if (!$templates) {
            return;
        }

        foreach ($templates->getTemplates() as $template) {
            if (!$template->getPublisherValidator()->skipItem()) {
                $pkg = null;
                if ($template->getPackage()) {
                    $pkg = \Package::getByHandle($template->getPackage());
                }
                Template::add($template->getHandle(), $template->getName(), $template->getIcon(), $pkg, $template->getIsInternal());
            }
        }
    }
}
