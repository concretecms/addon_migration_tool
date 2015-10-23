<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKeyObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\TypeInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class AttributeKey implements TypeInterface
{

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $manager = \Core::make('migration/manager/import/attribute/key');
        $categoryManager = \Core::make('migration/manager/import/attribute/category');
        $collection = new AttributeKeyObjectCollection();
        if ($element->attributekeys->attributekey) {
            foreach($element->attributekeys->attributekey as $node) {
                $importer = $manager->driver((string) $node['type']);
                $key = $importer->getEntity();
                $key->setHandle((string) $node['handle']);
                $key->setName((string) $node['name']);
                $key->setPackage((string) $node['package']);
                $categoryImporter = $categoryManager->driver((string) $node['category']);
                $category = $categoryImporter->getEntity();
                $categoryImporter->loadFromXml($category, $node);
                $key->setCategory($category);
                if ((string) $node['indexed'] == 1) {
                    $key->setIsIndexed(true);
                }
                if ((string) $node['searchable'] == 1) {
                    $key->setIsSearchable(true);
                }
                $importer->loadFromXml($key, $node);
                $collection->getKeys()->add($key);
                $key->setCollection($collection);
            }
        }
        return $collection;
    }

}
