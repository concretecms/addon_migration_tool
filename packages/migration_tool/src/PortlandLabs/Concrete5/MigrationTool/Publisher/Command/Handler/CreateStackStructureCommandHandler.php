<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler;

use Concrete\Core\Page\Stack\Stack;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateStackStructureCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateStackStructureCommandHandler extends AbstractPageCommandHandler
{

    public function getPage($id)
    {
        $entityManager = \Database::connection()->getEntityManager();
        $r = $entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\AbstractStack');
        return $r->findOneById($id);
    }

    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $parent = null;
        /**
         * @var $command CreateStackStructureCommand
         */
        $command = $this->command;
        $stack = $this->getPage($command->getPageId());
        $logger->logPublishStarted($stack);
        if ($stack->getPath() || $stack->getName()) {
            if ($stack->getPath() != '') {
                $lastSlash = strrpos($stack->getPath(), '/');
                $parentPath = substr($stack->getPath(), 0, $lastSlash);
                if ($parentPath) {
                    $parent = \Concrete\Core\Support\Facade\StackFolder::getByPath($parentPath, 'RECENT', $batch->getSite()->getSiteTreeObject());
                }
            }

            switch ($stack->getType()) {
                case 'folder':
                    $folder = \Concrete\Core\Support\Facade\StackFolder::getByPath($stack->getName(), $batch->getSite()->getSiteTreeObject());
                    if (!is_object($folder)) {
                        $folder = \Concrete\Core\Support\Facade\StackFolder::add($stack->getName(), $parent);
                        $logger->logPublishComplete($stack, $folder);
                    } else {
                        $logger->logSkipped($stack);
                    }
                    break;
                case 'global_area':
                    $s = Stack::getByName($stack->getName(), 'RECENT', $batch->getSite()->getSiteTreeObject());
                    if (!is_object($s)) {
                        if (method_exists('\Concrete\Core\Page\Stack\Stack', 'addGlobalArea')) {
                            $s = Stack::addGlobalArea($stack->getName(), $batch->getSite()->getSiteTreeObject());
                            $logger->logPublishComplete($stack, $s);
                        } else {
                            //legacy
                            $s = Stack::addStack($stack->getName(), 'global_area');
                            $logger->logPublishComplete($stack, $s);
                        }
                    }
                    break;
                default:
                    //stack
                    if (method_exists('\Concrete\Core\Page\Stack\Stack', 'getByPath') && $stack->getPath()) {
                        $s = Stack::getByPath($stack->getPath(), 'RECENT', $batch->getSite()->getSiteTreeObject());
                        if (!is_object($s)) {
                            $s = Stack::addStack($stack->getName(), $parent);
                            $logger->logPublishComplete($stack, $s);
                        } else {
                            $logger->logSkipped($stack);
                        }
                    } else {
                        $s = Stack::getByName($stack->getName(), 'RECENT', $batch->getSite()->getSiteTreeObject());
                        if (!is_object($s)) {
                            // legacy, so no folder support
                            $s = Stack::addStack($stack->getName());
                            $logger->logPublishComplete($stack, $s);
                        } else {
                            $logger->logSkipped($stack);
                        }
                    }
                    break;
            }
        }
    }
}
