<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\EmptyMapper;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;

defined('C5_EXECUTE') or die("Access Denied.");

class TransformContentTypesTask implements TaskInterface
{

    protected $mappers;
    protected $transformers;

    public function __construct(MapperManagerInterface $mappers)
    {
        $this->mappers = $mappers;
    }

    public function execute(ActionInterface $action)
    {
        $target = $action->getTarget();
        $subject = $action->getSubject();
        $batch = $target->getBatch();

        $transformers = \Core::make('migration/manager/transforms');
        $transformer = $transformers->driver($subject['transformer']);
        $item = $transformer->getItem($subject);
        // Since batch is serialized we do this:
        $em = \Database::connection()->getEntityManager();
        $batch = $em->getRepository('PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch')->findOneById($batch->getId());
        $mapper = $this->mappers->driver($subject['mapper']);

        if (is_object($item)) {
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if (is_object($targetItem)) {
                if (!($targetItem instanceof UnmappedTargetItem || $target instanceof IgnoredTargetItem)) {
                    $transformer->transform($subject, $mapper, $item, $targetItem, $batch);
                }
            }
        }

    }

    public function finish(ActionInterface $action)
    {
        return;
    }
}
