<?php
namespace Concrete\Package\MigrationTool\Backup\ContentImporter\ValueInspector\Item;

use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageItem;
use Concrete\Core\Page\Page;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

class BatchPageItem extends PageItem
{

    protected $batch;

    public function __construct(Batch $batch, $reference)
    {
        $this->batch = $batch;
        parent::__construct($reference);
    }

    public function getContentObject()
    {

        // First, does the passed path exist in the site? If so, we consider this solved
        // This is handled by the parent class
        $object = parent::getContentObject();
        if ($object) {
            return $object;
        }

        $cPath = $this->getReference();
        $entityManager = \ORM::entityManager();

        // Now, let's check to see if the path matches the original path of a page in the batch
        $query = $entityManager->createQuery('select p from
\PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\Page p
inner join p.entry e
inner join e.log l where l.batch_id = :batch_id and p.original_path = :original_path'
        );
        $query->setParameter('batch_id', $this->batch->getID());
        $query->setParameter('original_path', $cPath);

        $loggedPage = $query->getResult()[0];

        if (is_object($loggedPage)) {
            return Page::getByID($loggedPage->getPublishedPageID(), 'ACTIVE');
        }
    }

}
