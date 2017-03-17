<?php
namespace Concrete\Package\MigrationTool\Controller\SinglePage\Dashboard\System\Migration\Import\Settings;

use Concrete\Package\MigrationTool\Controller\Element\Dashboard\Batches\Settings\Header;
use Concrete\Package\MigrationTool\Page\Controller\DashboardMigrationSettingsController;

class Files extends DashboardMigrationSettingsController
{

    public function view($id = null)
    {
        $batch = $this->getBatch($id);
        if (is_object($batch)) {
            $this->set('headerMenu', new Header($batch));
            $this->set('batch', $batch);
            $this->set('pageTitle', t('Files Settings'));
        } else {
            $this->redirect('/dashboard/system/migration');
        }
    }

}