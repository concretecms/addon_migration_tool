<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;

use Concrete\Core\Attribute\Controller;
use Concrete\Core\Attribute\Key\Category;
use Concrete\Core\Attribute\Key\Key as CoreAttributeKey;
use Concrete\Core\Entity\Attribute\Key\Key;
use Concrete\Core\Entity\Attribute\Key\Type\AddressType;
use Concrete\Core\Entity\Attribute\Key\Type\Type;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AddressAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class AbstractPublisher implements PublisherInterface
{

    protected function publishAttribute(AttributeKey $source, Type $key_type, Key $destination)
    {
        $key_type->setAttributeKey($destination);
        $key_type->setAttributeType(\Concrete\Core\Attribute\Type::getByHandle($source->getType()));
        $destination->setAttributeKeyType($key_type);

        // Modify the category's search indexer.
        $category = Category::getByHandle($source->getCategory())->getController();
        $indexer = $category->getSearchIndexer();
        if (is_object($indexer)) {
            $indexer->updateRepository($category, $destination);
        }

        $em = \Database::connection()->getEntityManager();
        $em->persist($destination);
        $em->flush();

        return $destination;

    }

}
