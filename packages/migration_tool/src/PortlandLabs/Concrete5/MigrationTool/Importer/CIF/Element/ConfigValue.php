<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ConfigValueObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ConfigValue implements ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $collection = new ConfigValueObjectCollection();
        if ($element->config) {
            foreach ($element->config->children() as $node) {
                $config = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\ConfigValue();
                $config->setConfigKey((string) $node->getName());
                $config->setConfigValue((string) $node);
                $config->setPackage((string) $node['package']);
                $collection->getValues()->add($config);
                $config->setCollection($collection);
            }
        }

        return $collection;
    }
}
