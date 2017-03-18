<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch;

use Concrete\Core\Application\Application;
use Concrete\Core\Entity\Site\Site;
use Concrete\Core\File\Filesystem;
use Concrete\Core\Page\Single;
use Doctrine\ORM\EntityManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

class BatchService
{

    protected $entityManager;
    protected $application;
    protected $filesystem;

    public function __construct(Application $application, EntityManagerInterface $entityManager, Filesystem $filesystem)
    {
        $this->application = $application;
        $this->entityManager = $entityManager;
        $this->filesystem = $filesystem;
    }

    public function addBatch($notes, Site $site = null)
    {
        $batch = new Batch();
        $batch->setNotes($notes);
        if (!is_object($site)) {
            $site = $this->application->make('site')->getDefault();
        }
        $batch->setSite($site);
        $batch->setFileFolderID($this->filesystem->getRootFolder()->getTreeNodeID());
        $this->entityManager->persist($batch);
        $this->entityManager->flush();

        $this->createImportNode($site);

        return $batch;
    }

    protected function createImportNode(Site $site)
    {
        $batches = \Page::getByPath('/!import_batches', 'RECENT', $site->getSiteTreeObject()
        );
        if (!is_object($batches) || $batches->isError()) {
            $c = Single::add('/!import_batches', \Package::getByHandle('migration_tool'), true);
            $c->update(array('cName' => 'Import Batches'));
            $c->setOverrideTemplatePermissions(1);
            $c->setAttribute('icon_dashboard', 'fa fa-cubes');
        }
    }
}