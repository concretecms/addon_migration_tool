<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;

use Concrete\Core\Attribute\Key\Key as CoreAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AddressAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class AddressPublisher implements PublisherInterface
{
    /**
     * @param AddressAttributeKey $source
     * @param CoreAttributeKey $destination
     */
    public function publish(AttributeKey $source, CoreAttributeKey $destination)
    {
        $controller = $destination->getController();
        $data = array();
        $data['akHasCustomCountries'] = $source->getHasCustomCountries();
        $data['akDefaultCountry'] = $source->getDefaultCountry();
        foreach ($source->getCustomCountries() as $country) {
            $data['akCustomCountries'][] = $country;
        }
        $controller->saveKey($data);
    }
}
