<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Core;
use Doctrine\ORM\EntityManager;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class SummaryField extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Name'));
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $em = Core::make(EntityManager::class);
        $node = $element->addChild('summaryfields');
        foreach ($collection->getItems() as $field) {
            $entity = $em->find(\Concrete\Core\Entity\Summary\Field::class, $field->getItemIdentifier());
            if (is_object($entity)) {
                $this->exporter->export($entity, $node);
            }
        }
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $em = Core::make(EntityManager::class);
        $entity = $em->find(\Concrete\Core\Entity\Summary\Field::class, $exportItem->getItemIdentifier());
        return array($entity->getName());
    }

    public function getItemsFromRequest($array)
    {
        $em = Core::make(EntityManager::class);
        $items = array();
        foreach ($array as $id) {
            $entity = $em->find(\Concrete\Core\Entity\Summary\Field::class, $id);
            if (is_object($entity)) {
                $field = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\SummaryField();
                $field->setItemId($entity->getID());
                $items[] = $field;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $em = Core::make(EntityManager::class);
        $list = $em->getRepository(\Concrete\Core\Entity\Summary\Field::class)->findAll();
        foreach ($list as $c) {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\SummaryField();
            $item->setItemId($c->getID());
            $items[] = $item;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'summary_field';
    }

    public function getPluralDisplayName()
    {
        return t('Summary Fields');
    }
}
