<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Pipeline\Stage;

use League\Pipeline\StageInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\BlockItem;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectCollectionValidatorSubject;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectValidatorSubject;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

class ValidateBlockTypesStage implements StageInterface
{

    /**
     * @param $result ValidatorResult
     */
    public function __invoke($result)
    {
        $subject = $result->getSubject();
        $batch = $subject->getBatch();
        $block = $subject->getObject();
        $validatorMessages = $result->getMessages();
        $mapper = new \PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\BlockType();
        $targetItemList = new TargetItemList($batch, $mapper);
        if ($block->getType()) {
            $item = new BlockItem($block);
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if ($targetItem instanceof UnmappedTargetItem) {
                $validatorMessages->addMessage(
                    new Message(t('Block type <strong>%s</strong> does not exist.', $item->getIdentifier()))
                );
            }
        } elseif ($block->getDefaultsOutputIdentifier()) {
            // This is a block on a page that is pulling its content from page defaults. We need to find
            // a block with the corresponding string in page defaults. Otherwise we're going to have a problem.
            $area = $block->getArea();
            $found = false;
            if (is_object($area)) {
                $page = $area->getPage();
                if (is_object($page)) {
                    $type = $page->getType();
                    $template = $page->getTemplate();
                    if ($type && $template) {
                        // Retrieve the page  type by handle.
                        $em = \Package::getByHandle('migration_tool')->getEntityManager();
                        $r1 = $em->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\PageType');
                        $pageType = $r1->findOneByHandle($type);
                        if (is_object($pageType)) {
                            $defaults = $pageType->getDefaultPageCollection();
                            foreach ($defaults->getPages() as $default) {
                                if ($default->getTemplate() == $template) {
                                    // whew. We've located the proper place.
                                    foreach ($default->getAreas() as $area) {
                                        foreach ($area->getBlocks() as $defaultBlock) {
                                            if ($defaultBlock->getDefaultsOutputIdentifier() == $block->getDefaultsOutputIdentifier()) {
                                                $found = true;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if (!$found) {
                $validatorMessages->addMessage(
                    new Message(t('Page Type Defaults Output Reference <strong>%s</strong> not found within corresponding defaults.', $block->getDefaultsOutputIdentifier()))
                );
            }
        }

        return $result;
    }

}
