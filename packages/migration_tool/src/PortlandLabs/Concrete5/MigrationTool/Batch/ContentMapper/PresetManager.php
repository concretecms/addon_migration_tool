<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper;

use Concrete\Core\Support\Manager as CoreManager;
use Doctrine\ORM\EntityManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
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

}
