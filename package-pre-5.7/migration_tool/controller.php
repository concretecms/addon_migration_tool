<?php

defined('C5_EXECUTE') or die(_("Access Denied."));

class MigrationToolPackage extends Package
{

    protected $pkgHandle = 'migration_tool';
    protected $appVersionRequired = '5.5.0';
    protected $pkgVersion = '0.6.1';

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
        SinglePage::add('/dashboard/migration', $pkg);
        SinglePage::add('/dashboard/migration/batches', $pkg);
        SinglePage::add('/dashboard/migration/batches/add_pages', $pkg);
        SinglePage::add('/dashboard/migration/batches/export', $pkg);
    }

}