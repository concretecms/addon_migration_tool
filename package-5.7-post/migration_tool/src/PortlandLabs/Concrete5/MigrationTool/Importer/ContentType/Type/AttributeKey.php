<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKeyObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\TypeInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class AttributeKey implements TypeInterface
{

    protected $simplexml;

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $collection = new AttributeKeyObjectCollection();
        if ($element->attributekeys->attributekey) {
            foreach($this->simplexml->blocktypes->blocktype as $node) {
                $type = new CoreBlockType();
                $type->setHandle((string) $node['handle']);
                $type->setPackage((string) $node['package']);
                $collection->getTypes()->add($type);
                $type->setCollection($collection);
            }
        }
        return $collection;
    }

}
