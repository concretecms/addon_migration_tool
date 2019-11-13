<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Core;
use Doctrine\ORM\EntityManager;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class SummaryCategory extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Name'));
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $em = Core::make(EntityManager::class);
        $node = $element->addChild('summarycategories');
        foreach ($collection->getItems() as $category) {
            $entity = $em->find(\Concrete\Core\Entity\Summary\Category::class, $category->getItemIdentifier());
            if (is_object($entity)) {
                $this->exporter->export($entity, $node);
            }
        }
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $em = Core::make(EntityManager::class);
        $entity = $em->find(\Concrete\Core\Entity\Summary\Category::class, $exportItem->getItemIdentifier());
        return array($entity->getName());
    }

    public function getItemsFromRequest($array)
    {
        $em = Core::make(EntityManager::class);
        $items = array();
        foreach ($array as $id) {
            $entity = $em->find(\Concrete\Core\Entity\Summary\Category::class, $id);
            if (is_object($entity)) {
                $category = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\SummaryCategory();
                $category->setItemId($entity->getID());
                $items[] = $category;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $em = Core::make(EntityManager::class);
        $list = $em->getRepository(\Concrete\Core\Entity\Summary\Category::class)->findAll();
        foreach ($list as $c) {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\SummaryCategory();
            $item->setItemId($c->getID());
            $items[] = $item;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'summary_category';
    }

    public function getPluralDisplayName()
    {
        return t('Summary Categories');
    }
}
