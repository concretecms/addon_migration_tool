<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;

use Concrete\Core\Entity\Attribute\Key\Type\AddressType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class AddressPublisher extends AbstractPublisher
{
    public function publish(AttributeKey $source, $destination)
    {
        if (class_exists('\Concrete\Core\Entity\Attribute\Key\Type\Type')) {
            // version 8
            $key_type = new AddressType();
            $key_type->setHasCustomCountries($source->getHasCustomCountries());
            $key_type->setDefaultCountry($source->getDefaultCountry());
            $key_type->setCustomCountries($source->getCustomCountries());

            return $this->publishAttribute($source, $key_type, $destination);
        } else {
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
}
