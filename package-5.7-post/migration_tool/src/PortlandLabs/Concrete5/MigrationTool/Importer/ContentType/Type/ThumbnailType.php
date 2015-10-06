<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockTypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockType as CoreBlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplateObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ThumbnailTypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\TypeInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ThumbnailType implements TypeInterface
{

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $collection = new ThumbnailTypeObjectCollection();
        if ($element->thumbnailtypes->thumbnailtype) {
            foreach($element->thumbnailtypes->thumbnailtype as $node) {
                $type = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\ThumbnailType();
                $type->setHandle((string) $node['handle']);
                $type->setName((string) $node['name']);
                $type->setWidth(intval((string) $node['width']));
                $type->setHeight(intval((string) $node['height']));
                $required = (string) $node['required'];
                if ($required) {
                    $type->setIsRequired(true);
                }
                $collection->getTypes()->add($type);
                $type->setCollection($collection);
            }
        }
        return $collection;
    }

}
