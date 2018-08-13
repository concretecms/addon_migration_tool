<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Pipeline\Stage;

use League\Pipeline\StageInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Area;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateAreasStage implements StageInterface
{
    public function __invoke($result)
    {
        $subject = $result->getSubject();
        $batch = $subject->getBatch();
        $page = $subject->getObject();

        $areaMapper = new Area();
        $targetItemList = new TargetItemList($batch, $areaMapper);
        foreach ($page->getAreas() as $area) {
            $item = new Item($area->getName());
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if ($targetItem instanceof UnmappedTargetItem) {
                $template = $page->getTemplate();
                // Now, if the page template exists in the batch, there's a chance that the reason the area
                // doesn't exist in the site is because it's part of the new template. In that case, we should show
                // an info message so we don't get as many scary red errors.
                if ($template) {
                    $em = \Package::getByHandle('migration_tool')->getEntityManager();
                    $r = $em->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplate');
                    $batchTemplate = $r->findOneByHandle($template);
                }

                if (isset($batchTemplate) && is_object($batchTemplate)) {
                    $result->getMessages()->add(
                        new Message(t('Area <strong>%s</strong> does not exist in site. If this area is in a new page template this message can be disregarded.', $item->getIdentifier()), Message::E_INFO)
                    );
                } else {
                    $result->getMessages()->add(
                        new Message(t('Area <strong>%s</strong> does not exist.', $item->getIdentifier()))
                    );
                }
            }
        }
        return $result;
    }

}
