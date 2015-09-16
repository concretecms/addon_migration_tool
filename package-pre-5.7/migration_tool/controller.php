<?php

defined('C5_EXECUTE') or die(_("Access Denied."));

class MigrationToolPackage extends Package
{

    protected $pkgHandle = 'migration_tool';
    protected $appVersionRequired = '5.5.0';
    protected $pkgVersion = '0.5';

    public function getPackageDescription()
    {
        return t('Generates content from a 5.5 or greater concrete5 site for import into a modern concrete5 installation.');
    }

    public function getPackageName()
    {
        return t('Migration Tool');
    }

    public function install()
    {
        $pkg = parent::install();
        Loader::model('single_page');
        $p = SinglePage::add('/dashboard/migrate', $pkg);
    }

}