<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\UserObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\ElementParserInterface;

class User implements ElementParserInterface
{
    private $namespaces;

    public function getObjectCollection(\SimpleXMLElement $xml, array $namespaces)
    {
        $this->namespaces = $namespaces;

        $collection = new UserObjectCollection();
        // grab authors
        foreach ($xml->xpath('/rss/channel/wp:author') as $author_arr) {
            $a = $author_arr->children($namespaces['wp']);
            $user = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\User();
            $user->setName((string) $a->author_login);
            $user->setEmail((string) $a->author_email);
            $collection->getUsers()->add($user);
            $user->setCollection($collection);
        }

        return $collection;
    }
}
