<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BannedWordObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\CaptchaObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ContentEditorSnippetObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\FlagType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\FlagTypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplate as CorePageTemplate;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplateObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\SocialLinkObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ThemeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow\Type;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow\TypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\TypeInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ContentEditorSnippet implements TypeInterface
{

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $collection = new ContentEditorSnippetObjectCollection();
        if ($element->systemcontenteditorsnippets->snippet) {
            foreach($element->systemcontenteditorsnippets->snippet as $node) {
                $snippet = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\ContentEditorSnippet();
                $snippet->setHandle((string) $node['handle']);
                $snippet->setName((string) $node['name']);
                $snippet->setPackage((string) $node['package']);
                $snippet->setIsActivated((string) $node['activated']);
                $collection->getSnippets()->add($snippet);
                $snippet->setCollection($collection);
            }
        }
        return $collection;
    }

}
