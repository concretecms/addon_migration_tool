<?php

namespace Concrete\Package\MigrationTool;

use Concrete\Core\Package\Package;
use Concrete\Core\Page\Type\Type;
use Page;
use PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator;
use SinglePage;

class Controller extends Package
{

    protected $pkgHandle = 'migration_tool';
    protected $appVersionRequired = '5.7.5.3a1';
    protected $pkgVersion = '0.5.1';
    protected $pkgAutoloaderMapCoreExtensions = true;
    protected $pkgAutoloaderRegistries = array(
        'src/PortlandLabs/Concrete5/MigrationTool' => '\PortlandLabs\Concrete5\MigrationTool'
    );

    protected $singlePages = array(
        '/dashboard/system/migration',
        '/dashboard/system/migration/import_content'
    );

    protected $singlePagesToExclude = array(
    );

    protected $singlePageTitles = array(
        '/dashboard/system/migration' => 'Migration Tool'
    );

    protected function installSinglePages($pkg)
    {
        foreach($this->singlePages as $path) {
            if (Page::getByPath($path)->getCollectionID() <= 0) {
                SinglePage::add($path, $pkg);
            }

            $pp = Page::getByPath($path);
            if (in_array($path, $this->singlePagesToExclude)) {
                if (is_object($pp) && !$pp->isError()) {
                    $pp->setAttribute('exclude_nav', true);
                    $pp->setAttribute('exclude_search_index', true);
                }
            }

            if (isset($this->singlePageTitles[$path])) {
                $pp->update(array('cName'=> $this->singlePageTitles[$path]));
            }
        }

        $batches = \Page::getByPath('/!import_batches');
        if (!is_object($batches) || $batches->isError()) {
            $c = SinglePage::add('/!import_batches', $pkg);
            $c->update(array('cName' => 'Import Batches'));
            $c->setOverrideTemplatePermissions(1);
            $c->setAttribute('icon_dashboard', 'fa fa-cubes');
            $c->moveToRoot();
        }
    }

    public function on_start()
    {
        \Core::bindShared('migration/batch/page/validator', function () {
            return new Validator();
        });

    }

    public function getPackageDescription()
    {
        return t("Migration Tool");
    }

    public function getPackageName()
    {
        return t("Migration Tool");
    }

    public function install()
    {
        $pkg = parent::install();
        $this->installSinglePages($pkg);
        $this->installPageTypes($pkg);
    }

    protected function installPagetypes($pkg)
    {
        $type = Type::getByHandle('import_batch');
        if (!is_object($type)) {
            Type::add(array(
                'internal' => true,
                'name' => 'Import Batch',
                'handle' => 'import_batch'
            ));
        }
    }

    public function upgrade()
    {
        parent::upgrade();
        $pkg = \Package::getByHandle('migration_tool');
        $this->installSinglePages($pkg);
        $this->installPageTypes($pkg);
    }


}