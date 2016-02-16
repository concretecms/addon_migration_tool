<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use Doctrine\DBAL\Logging\EchoSQLLogger;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\ImportedBlockValue;

defined('C5_EXECUTE') or die("Access Denied.");

class NormalizePagePathsTask implements TaskInterface
{
    protected $paths = array();

    public function execute(ActionInterface $action)
    {
        $subject = $action->getSubject();
        $path = trim($subject->getOriginalPath(), '/');
        $this->paths[] = $path;
    }

    public function finish(ActionInterface $action)
    {
        $entityManager = \Package::getByHandle('migration_tool')->getEntityManager();
        $target = $action->getTarget();
        $paths = $this->paths;
        $n = count($paths);
        $common = '';
        $offset = 1;
        if (isset($paths[0]) && $paths[0]) {
            while (strpos($paths[0], '/', $offset) !== FALSE) {
                $offset = strpos($paths[0], '/', $offset) + 1;
                $c = substr($paths[0], 0, $offset);
                for ($i = 1; $i < $n; $i++) {
                    if (substr($paths[$i], 0, $offset) !== $c) {
                        break 2;
                    }
                }
                $common = $c;
            }
        }
        $pages = $target->getBatch()->getPages();

       // $entityManager->getConnection()->getConfiguration()->setSQLLogger(new EchoSQLLogger());

        if ($common && count($pages) > 1) {
            $common = '/' . trim($common, '/');
            $contentSearchURL = "/\{ccm:export:page:" . preg_quote($common, '/') . "(.*?)\}/i";
            $contentReplaceURL = "{ccm:export:page:$1}";
            foreach ($pages as $page) {
                $originalPath = $page->getOriginalPath();
                $newPath = substr($originalPath, strlen($common));

                if ($page->canNormalizePath()) {
                    $page->setBatchPath($newPath);
                }

                $areas = $page->getAreas();
                foreach ($areas as $area) {
                    $blocks = $area->getBlocks();
                    foreach ($blocks as $block) {
                        $value = $block->getBlockValue();
                        if ($value instanceof ImportedBlockValue) {
                            $content = preg_replace($contentSearchURL, $contentReplaceURL, $value->getValue());
                            $query = $entityManager->createQuery("update \PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\ImportedBlockValue v
                            set v.value = :value where v.id = :primary");
                            $query->setParameter('primary', $value->getID());
                            $query->setParameter('value', $content);
                            $query->execute();
                        }
                    }
                }
            }
        } else {
            foreach ($pages as $page) {
                if ($page->canNormalizePath()) {
                    $page->setBatchPath($page->getOriginalPath());
                }
            }
        }
    }
}
