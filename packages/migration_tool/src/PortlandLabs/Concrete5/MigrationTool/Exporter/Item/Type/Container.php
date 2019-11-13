<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Core;
use Doctrine\ORM\EntityManager;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class Container extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Name'));
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $em = Core::make(EntityManager::class);
        $node = $element->addChild('containers');
        foreach ($collection->getItems() as $container) {
            $entity = $em->find(\Concrete\Core\Entity\Page\Container::class, $container->getItemIdentifier());
            if (is_object($entity)) {
                $this->exporter->export($entity, $node);
            }
        }
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $em = Core::make(EntityManager::class);
        $entity = $em->find(\Concrete\Core\Entity\Page\Container::class, $exportItem->getItemIdentifier());
        return array($entity->getContainerName());
    }

    public function getItemsFromRequest($array)
    {
        $em = Core::make(EntityManager::class);
        $items = array();
        foreach ($array as $id) {
            $entity = $em->find(\Concrete\Core\Entity\Page\Container::class, $id);
            if (is_object($entity)) {
                $container = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\Container();
                $container->setItemId($entity->getContainerID());
                $items[] = $container;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $em = Core::make(EntityManager::class);
        $list = $em->getRepository(\Concrete\Core\Entity\Page\Container::class)->findAll();
        foreach ($list as $c) {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\Container();
            $item->setItemId($c->getContainerID());
            $items[] = $item;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'container';
    }

    public function getPluralDisplayName()
    {
        return t('Containers');
    }
}
