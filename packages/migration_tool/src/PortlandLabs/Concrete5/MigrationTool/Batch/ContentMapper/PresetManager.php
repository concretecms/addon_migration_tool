<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper;

use Concrete\Core\Support\Manager as CoreManager;
use Doctrine\ORM\EntityManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Area;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\SiteAttribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\ComposerOutputContent;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\PageTemplate;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\PageType;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\User;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchPresetTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class PresetManager
{

    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getPresets(Batch $batch)
    {
        $r = $this->entityManager->getRepository('PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchPresetTargetItem');
        return $r->findByBatch($batch);
    }

    public function clearPresets(Batch $batch)
    {
        foreach($this->getPresets($batch) as $preset) {
            $this->entityManager->remove($preset);
        }
        $this->entityManager->flush();
    }

    public function clearBatchMappings(Batch $batch)
    {
        $r = $this->entityManager->getRepository('PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchTargetItem');
        foreach($r->findByBatch($batch) as $targetItem) {
            $this->entityManager->remove($targetItem);
        }
        $this->entityManager->flush();
    }

    public function savePresets(Batch $batch, $items)
    {
        foreach($items as $item) {
            /**
             * @var $item BatchPresetTargetItem
             */
            $item->setBatch($batch);
            $this->entityManager->persist($item);
        }
        $this->entityManager->flush();
    }

    public function getMatchedTargetItem(MapperInterface $mapper, Batch $batch, ItemInterface $item)
    {
        $query = $this->entityManager->createQuery(
            "select ti from PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchPresetTargetItem bpti
            join PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem ti
            where bpti.batch = :batch and bpti.target_item = ti and ti.item_type = :type and ti.source_item_identifier = :source_item_identifier"
        );
        $query->setParameter('batch', $batch);
        $query->setParameter('source_item_identifier', $item->getIdentifier());
        $query->setParameter('type', $mapper->getHandle());
        $targetItem = $query->getResult();
        if (is_object($targetItem[0])) {
            // We need to return a NEW target item based off of this preset
            return clone $targetItem[0];
        }

    }

}
