<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Captcha\Library;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateCaptchaLibrariesRoutine implements RoutineInterface
{
    public function execute(Batch $batch)
    {
        $libraries = $batch->getObjectCollection('captcha_library');

        if (!$libraries) {
            return;
        }

        foreach ($libraries->getLibraries() as $library) {
            if (!$library->getPublisherValidator()->skipItem()) {
                $pkg = null;
                if ($library->getPackage()) {
                    $pkg = \Package::getByHandle($library->getPackage());
                }
                $l = Library::add($library->getHandle(), $library->getName(), $pkg);
                if ($library->getIsActivated()) {
                    $l->activate();
                }
            }
        }
    }
}
