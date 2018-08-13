<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Pipeline\Stage;

use Concrete\Core\Page\Type\Type;
use League\Pipeline\StageInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\ComposerOutputContent;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\PageType;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidatePageTypesStage implements StageInterface
{
    public function __invoke($result)
    {
        $subject = $result->getSubject();
        $batch = $subject->getBatch();
        $page = $subject->getObject();

        if ($page->getType()) {
            $mapper = new PageType();
            $targetItemList = new TargetItemList($batch, $mapper);
            $item = new Item($page->getType());
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if (!($targetItem instanceof IgnoredTargetItem)) {
                if ($targetItem instanceof UnmappedTargetItem) {
                    $result->getMessages()->add(
                        new Message(t('Page Type <strong>%s</strong> does not exist.', $item->getIdentifier()))
                    );
                } else {
                    $targetPageType = Type::getByID($targetItem->getItemID());
                    if (is_object($targetPageType)) {
                        $composerMapper = new ComposerOutputContent();
                        $composerTargetItemList = new TargetItemList($batch, $composerMapper);
                        $items = $composerMapper->getPageTypeComposerOutputContentItems($targetPageType);
                        foreach ($items as $item) {
                            $targetItem = $composerTargetItemList->getSelectedTargetItem($item);
                            if ($targetItem instanceof UnmappedTargetItem) {
                                $result->getMessages()->add(
                                    new Message(t('Mapped page type %s contains unmapped composer output block in %s area.',
                                        $targetPageType->getPageTypeDisplayName(),
                                        $item->getBlock()->getAreaHandle()
                                    ))
                                );
                            }
                        }
                    }
                }
            }
        }

        return $result;
    }

}
