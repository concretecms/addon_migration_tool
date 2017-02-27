<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Stack\Stack;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;

defined('C5_EXECUTE') or die("Access Denied.");

class PublishStackContentRoutineAction extends AbstractPageAction
{
    public function populatePageObject($id)
    {
        $entityManager = \Database::connection()->getEntityManager();
        $r = $entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Stack');
        $this->page = $r->findOneById($id);
    }

    public function execute(BatchInterface $batch)
    {
        $stack = $this->page;
        if (method_exists('\Concrete\Core\Page\Stack\Stack', 'getByPath')) {
            $s = Stack::getByPath($stack->getPath());
        } else {
            $s = Stack::getByName($stack->getName());
        }
        if (is_object($s)) {
            foreach ($stack->getBlocks() as $block) {
                $bt = $this->getTargetItem($batch, 'block_type', $block->getType());
                if (is_object($bt)) {
                    $value = $block->getBlockValue();
                    $publisher = $value->getPublisher();
                    $area = new Area();
                    $area->setName(STACKS_AREA_NAME);
                    $b = $publisher->publish($batch, $bt, $s, $area, $value);
                    $styleSet = $block->getStyleSet();
                    if (is_object($styleSet)) {
                        $styleSetPublisher = $styleSet->getPublisher();
                        $publishedStyleSet = $styleSetPublisher->publish();
                        $b->setCustomStyleSet($publishedStyleSet);
                    }
                    if ($block->getCustomTemplate()) {
                        $b->setCustomTemplate($block->getCustomTemplate());
                    }
                }
            }
        }
    }
}
