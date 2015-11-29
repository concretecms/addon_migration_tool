<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Page;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\StyleSet\TreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Validator;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class TreePageJsonFormatter implements \JsonSerializable
{

    protected $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function jsonSerialize()
    {
        $nodes = array();
        $page = $this->page;
        $collection = $page->getCollection();
        $r = \Database::connection()->getEntityManager()->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
        $batch = $r->findFromCollection($collection);
        $validator = $collection->getRecordValidator($batch);
        $messages = $validator->validate($page);
        if ($messages->count()) {
            $messageHolderNode = new \stdClass;
            $messageHolderNode->iconclass = $messages->getFormatter()->getCollectionStatusIconClass();
            $messageHolderNode->title = t('Errors');
            $messageHolderNode->children = array();
            foreach($messages as $m) {
                $messageNode = new \stdClass;
                $messageNode->iconclass = $m->getFormatter()->getIconClass();
                $messageNode->title = $m->getFormatter()->output();
                $messageHolderNode->children[] = $messageNode;
            }
            $nodes[] = $messageHolderNode;
        }
        if ($page->getAttributes()->count()) {
            $attributeHolderNode = new \stdClass;
            $attributeHolderNode->iconclass = 'fa fa-cogs';
            $attributeHolderNode->title = t('Attributes');
            $attributeHolderNode->children = array();
            foreach($page->getAttributes() as $attribute) {
                $value = $attribute->getAttribute()->getAttributeValue();
                if (is_object($value)) {
                    $attributeFormatter = $value->getFormatter();
                    $attributeNode = $attributeFormatter->getBatchTreeNodeJsonObject();
                    $attributeHolderNode->children[] = $attributeNode;
                }
            }
            $nodes[] = $attributeHolderNode;
        }
        if ($page->getAreas()->count()) {
            $areaHolderNode = new \stdClass;
            $areaHolderNode->iconclass = 'fa fa-code';
            $areaHolderNode->title = t('Areas');
            $areaHolderNode->children = array();
            foreach($page->getAreas() as $area) {
                $areaNode = new \stdClass;
                $areaNode->iconclass = 'fa fa-cubes';
                $areaNode->title = $area->getName();
                if ($styleSet = $area->getStyleSet()) {
                    $styleSetFormatter = new TreeJsonFormatter($styleSet);
                    $areaNode->children[] = $styleSetFormatter->getBatchTreeNodeJsonObject();
                }
                foreach($area->getBlocks() as $block) {
                    $value = $block->getBlockValue();
                    if (is_object($value)) {
                        $blockFormatter = $value->getFormatter();
                        $blockNode = $blockFormatter->getBatchTreeNodeJsonObject();
                        if ($styleSet = $block->getStyleSet()) {
                            $styleSetFormatter = new TreeJsonFormatter($styleSet);
                            $blockNode->children[] = $styleSetFormatter->getBatchTreeNodeJsonObject();
                        }

                        $areaNode->children[] = $blockNode;
                    }

                }
                $areaHolderNode->children[] = $areaNode;
            }
            $nodes[] = $areaHolderNode;
        }
        return $nodes;
    }
}