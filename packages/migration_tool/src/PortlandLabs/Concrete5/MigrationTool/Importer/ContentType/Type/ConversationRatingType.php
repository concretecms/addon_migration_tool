<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\RatingType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\RatingTypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplate as CorePageTemplate;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplateObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\TypeInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ConversationRatingType implements TypeInterface
{

    protected $simplexml;

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $this->simplexml = $element;
        $collection = new RatingTypeObjectCollection();
        if ($this->simplexml->conversationratingtypes->conversationratingtype) {
            foreach($this->simplexml->conversationratingtypes->conversationratingtype as $node) {
                $type = new RatingType();
                $type->setHandle((string) $node['handle']);
                $type->setName((string) $node['name']);
                $type->setPoints((string) $node['points']);
                $type->setPackage((string) $node['package']);
                $collection->getTypes()->add($type);
                $type->setCollection($collection);
            }
        }
        return $collection;
    }

}
