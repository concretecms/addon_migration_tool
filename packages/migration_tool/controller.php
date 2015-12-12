<?php
namespace Concrete\Package\MigrationTool;

use Concrete\Core\Asset\AssetList;
use Concrete\Core\Package\Package;
use Concrete\Core\Page\Type\Type;
use Page;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Manager;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Block\CollectionValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Task\ValidateAreasTask;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Task\ValidateAttributesTask;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Task\ValidateBlocksTask;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Task\ValidateBlockTypesTask;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Task\ValidatePageTemplatesTask;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Task\ValidatePageTypesTask;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Task\ValidateReferencedContentItemsTask;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Task\ValidateUsersTask;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Validator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Task\ValidateBatchRecordsTask;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Value\Manager as AttributeValueManager;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Key\Manager as AttributeKeyManager;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Category\Manager as AttributeCategoryManager;
use PortlandLabs\Concrete5\MigrationTool\Importer\ParserManager;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Permission\AccessEntity\Manager as AccessEntityManager;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\PageType\PublishTarget\Manager as PublishTargetManager;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Block\Manager as CIFBlockManager;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Manager as CIFImportManager;
use PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\Manager as WordpressImportManager;
use PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\Block\Manager as WordpressBlockManager;
use PortlandLabs\Concrete5\MigrationTool\Publisher\ContentImporter\ValueInspector\InspectionRoutine\BatchPageRoutine;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Routine\Manager as PublisherManager;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Block\Manager as BlockPublisherManager;
use PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type\Manager as ExporterItemTypeManager;
use SinglePage;

class Controller extends Package
{
    protected $pkgHandle = 'migration_tool';
    protected $appVersionRequired = '5.7.5.4a1';
    protected $pkgVersion = '0.5.4';
    protected $pkgAutoloaderMapCoreExtensions = true;
    protected $pkgAutoloaderRegistries = array(
        'src/PortlandLabs/Concrete5/MigrationTool' => '\PortlandLabs\Concrete5\MigrationTool',
    );

    protected $singlePages = array(
        '/dashboard/system/migration',
        '/dashboard/system/migration/import',
        '/dashboard/system/migration/export',
    );

    protected $singlePagesToExclude = array(
    );

    protected function getSinglePageTitle($path)
    {
        switch ($path) {
            case '/dashboard/system/migration':
                return t('Migration Tool');
            case '/dashboard/system/migration/import':
                return t('Import Content');
            case '/dashboard/system/migration/export':
                return t('Export Content');
        }
    }

    protected function installSinglePages($pkg)
    {
        foreach ($this->singlePages as $path) {
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

            $title = $this->getSinglePageTitle($path);
            if (isset($title)) {
                $pp->update(array('cName' => $title));
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
        \Core::bind('migration/batch/page/validator', function ($app, $batch) {
            if (isset($batch[0])) {
                $v = new Validator($batch[0]);
                $v->registerTask(new ValidateAttributesTask());
                $v->registerTask(new ValidatePageTemplatesTask());
                $v->registerTask(new ValidatePageTypesTask());
                $v->registerTask(new ValidateUsersTask());
                $v->registerTask(new ValidateBlocksTask());
                $v->registerTask(new ValidateAreasTask());

                return $v;
            }
        });

        \Core::bindShared('migration/batch/validator', function () {
            $v = new BatchValidator();
            $v->registerTask(new ValidateBatchRecordsTask());

            return $v;
        });

        \Core::bind('migration/batch/block/validator', function ($app, $batch) {
            if (isset($batch[0])) {
                $v = new CollectionValidator($batch[0]);
                $v->registerTask(new ValidateBlockTypesTask());
                $v->registerTask(new ValidateReferencedContentItemsTask());

                return $v;
            }
        });

        \Core::bindShared('migration/manager/mapping', function ($app) {
            return new Manager($app);
        });
        \Core::bindShared('migration/manager/transforms', function ($app) {
            return new \PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Manager($app);
        });
        \Core::bindShared('migration/manager/import/attribute/value', function ($app) {
            return new AttributeValueManager($app);
        });
        \Core::bindShared('migration/manager/import/attribute/key', function ($app) {
            return new AttributeKeyManager($app);
        });
        \Core::bindShared('migration/manager/import/attribute/category', function ($app) {
            return new AttributeCategoryManager($app);
        });
        \Core::bindShared('migration/manager/import/permission/access_entity', function ($app) {
            return new AccessEntityManager($app);
        });

        \Core::bindShared('migration/manager/import/page_type/publish_target', function ($app) {
            return new PublishTargetManager($app);
        });

        \Core::bindShared('migration/manager/import/cif_block', function ($app) {
            return new CIFBlockManager($app);
        });
        \Core::bindShared('migration/manager/import/wordpress_block', function ($app) {
            return new WordpressBlockManager($app);
        });
        \Core::bindShared('migration/manager/importer/parser', function ($app) {
            return new ParserManager($app);
        });
        \Core::bindShared('migration/manager/importer/cif', function ($app) {
            return new CIFImportManager($app);
        });
        \Core::bindShared('migration/manager/importer/wordpress', function ($app) {
            return new WordpressImportManager($app);
        });
        \Core::bindShared('migration/manager/publisher', function ($app) {
            return new PublisherManager($app);
        });
        \Core::bindShared('migration/manager/publisher/block', function ($app) {
            return new BlockPublisherManager($app);
        });

        \Core::bind('migration/import/value_inspector', function ($app, $args) {
            if (isset($args[0])) {
                $inspector = $app->make('import/value_inspector');
                $inspector->registerInspectionRoutine(new BatchPageRoutine($args[0]));

                return $inspector;
            }
        });

        \Core::bindShared('migration/manager/exporters', function ($app) {
            return new ExporterItemTypeManager($app);
        });

        $al = AssetList::getInstance();
        $al->register(
            'javascript', 'fancytree', 'assets/jquery.fancytree/dist/jquery.fancytree-all.min.js',
            array('minify' => false, 'combine' => false), $this
        );
        $al->register(
            'css', 'fancytree/skin/bootstrap', 'assets/jquery.fancytree/dist/skin-bootstrap/ui.fancytree.min.css',
            array('minify' => false, 'combine' => false), $this
        );
        $al->register(
            'javascript', 'migration/batch-table-tree', 'assets/migration/BatchTableTree.js',
            array(), $this
        );
        $al->register(
            'css', 'migration/batch-table-tree', 'assets/migration/BatchTableTree.css',
            array(), $this
        );
        $al->registerGroup('migration/view-batch', array(
            array('javascript', 'jquery'),
            array('javascript', 'jquery/ui'),
            array('javascript', 'fancytree'),
            array('javascript', 'migration/batch-table-tree'),
            array('css', 'fancytree/skin/bootstrap'),
            array('css', 'migration/batch-table-tree'),
        ));
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
        if (version_compare(PHP_VERSION, '5.4.0', '<')) {
            throw new \Exception(t('This add-on requires PHP 5.4 or greater.'));
        }
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
                'handle' => 'import_batch',
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
