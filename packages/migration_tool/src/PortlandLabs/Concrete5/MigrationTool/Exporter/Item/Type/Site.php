<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Concrete\Core\Export\Item\Site as SiteExporter;
use Concrete\Core\Site\Service;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\StandardExportItem;
use Symfony\Component\HttpFoundation\Request;

class Site extends AbstractType
{

    protected $service;

    public function getHeaders()
    {
        return array(t('Name'));
    }

    public function __construct(Service $service, SiteExporter $exporter)
    {
        $this->service = $service;
        $this->exporter = $exporter;
    }


    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('sites');
        foreach ($collection->getItems() as $type) {
            $t = $this->service->getByID($type->getItemIdentifier());
            if (is_object($t)) {
                $this->exporter->export($t, $node);
            }
        }
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $t = $this->service->getByID($exportItem->getItemIdentifier());
        $return = array();
        if (is_object($t)) {
            $return[] = $t->getSiteName();
        }

        return $return;
    }

    public function getItemsFromRequest($array)
    {
        $items = array();
        foreach ($array as $id) {
            $t = $this->service->getByID($id);
            if (is_object($t)) {
                $type = new StandardExportItem();
                $type->setItemId($t->getSiteID());
                $items[] = $type;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $items = array();
        foreach ($this->service->getList() as $t) {
            $item = new StandardExportItem();
            $item->setItemId($t->getSiteID());
            $items[] = $item;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'site';
    }

    public function getPluralDisplayName()
    {
        return t('Sites');
    }
}
