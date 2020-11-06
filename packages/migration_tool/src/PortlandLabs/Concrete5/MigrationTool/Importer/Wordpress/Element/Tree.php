<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\TreeNode;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\TreeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\ElementParserInterface;

class Tree implements ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $xml, array $namespaces)
    {
        $collection = new TreeObjectCollection();

        $tree = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Tree();
        $tree->setType('topic');
        $tree->setName('Blog Entries');

        // grab cats
        foreach ($xml->xpath('/rss/channel/wp:category') as $term_arr) {
            $t = $term_arr->children($namespaces['wp']);
            $n = new TreeNode();
            $n->setType('topic');
            $n->setTitle((string) $t->cat_name);
            $n->setTree($tree);
            $tree->getNodes()->add($n);
        }

        $collection->getTrees()->add($tree);
        $tree->setCollection($collection);

        return $collection;
    }
}
