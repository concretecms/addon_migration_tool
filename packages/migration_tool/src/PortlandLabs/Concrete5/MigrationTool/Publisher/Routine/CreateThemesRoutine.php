<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Theme\Theme;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateThemesRoutine implements RoutineInterface
{
    public function execute(Batch $batch)
    {
        $themes = $batch->getObjectCollection('theme');

        if (!$themes) {
            return;
        }

        foreach ($themes->getThemes() as $theme) {
            if (!$theme->getPublisherValidator()->skipItem()) {
                $pkg = null;
                if ($theme->getPackage()) {
                    $pkg = \Package::getByHandle($theme->getPackage());
                }
                $t = Theme::add($theme->getHandle(), $pkg);
                if ($theme->getIsActivated()) {
                    $t->applyToSite();
                }
            }
        }
    }
}
