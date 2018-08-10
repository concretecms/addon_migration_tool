<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Command;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\PresetManager;

class NormalizePagePathsCommandHandler
{

    public function handle(NormalizePagePathsCommand $command)
    {
        // Since batch is serialized we do this:
        $em = \Database::connection()->getEntityManager();
        $batch = $em->getRepository('PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch')->findOneById($command->getBatchId());
        $pages = $batch->getPages();
        $paths = [];
        foreach($pages as $page) {
            $paths[] = trim($page->getOriginalPath(), '/');
        }
        $n = count($paths);
        $common = '';
        $offset = 1;
        if (isset($paths[0]) && $paths[0]) {
            while (strpos($paths[0], '/', $offset) !== false) {
                $offset = strpos($paths[0], '/', $offset) + 1;
                $c = substr($paths[0], 0, $offset);
                for ($i = 1; $i < $n; ++$i) {
                    if (substr($paths[$i], 0, $offset) !== $c) {
                        break 2;
                    }
                }
                $common = $c;
            }
        }

        if (count($pages) == 1) {
            // Then $common equals the part of the path up to the last slug.
            // So if our only page is /path/to/my/page, then $common = '/path/to/my';
            $common = substr($pages[0]->getOriginalPath(), 0, strrpos($pages[0]->getOriginalPath(), '/'));
        }
        if ($common) {
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
                            // doctrine is doing some dumb shit here so let's do a direct query
                            $db = $em->getConnection();
                            $db->executeQuery('update MigrationImportImportedBlockValues set value = ? where id = ?',
                                array($content, $value->getID())
                            );
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
        $em->flush();
    }


}