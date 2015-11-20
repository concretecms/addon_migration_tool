<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BannedWordObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\FlagType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\FlagTypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplate as CorePageTemplate;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplateObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow\Type;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow\TypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\TypeInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class BannedWord implements TypeInterface
{

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $collection = new BannedWordObjectCollection();
        if ($element->banned_words->banned_word) {
            foreach($element->banned_words->banned_word as $node) {
                $word = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\BannedWord();
                $word->setWord((string) $node);
                $collection->getWords()->add($word);
                $word->setCollection($collection);
            }
        }
        return $collection;
    }

}
