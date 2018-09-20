<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler;

use Concrete\Core\Page\Stack\Stack;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\PublishStackContentCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class PublishStackContentCommandHandler extends AbstractPageCommandHandler
{

    public function getPage($id)
    {
        $entityManager = \Database::connection()->getEntityManager();
        $r = $entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\AbstractStack');
        return $r->findOneById($id);
    }

    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        /**
         * @var $command PublishStackContentCommand
         */
        $command = $this->command;
        $stack = $this->getPage($command->getPageId());
        if ($stack->getPath() || $stack->getName()) {
            if (method_exists('\Concrete\Core\Page\Stack\Stack', 'getByPath') && $stack->getPath()) {
                $s = Stack::getByPath($stack->getPath(), 'RECENT', $batch->getSite()->getSiteTreeObject());
            } else {
                $s = Stack::getByName($stack->getName(), 'RECENT', $batch->getSite()->getSiteTreeObject());
            }
            if (is_object($s)) {
                foreach ($stack->getBlocks() as $block) {
                    $bt = $this->getTargetItem($batch, 'block_type', $block->getType());
                    if (is_object($bt)) {
                        $value = $block->getBlockValue();
                        $publisher = $value->getPublisher();
                        $b = $publisher->publish($batch, $bt, $s, STACKS_AREA_NAME, $value);
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
}
