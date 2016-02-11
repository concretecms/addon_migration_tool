<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute;

use Concrete\Attribute\Address\Value;
use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Attribute\ObjectTrait;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AddressAttributeValue;
use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class AddressPublisher implements PublisherInterface
{
    /**
     * @param CollectionKey $ak
     * @param Page $page
     * @param AddressAttributeValue $address
     */
    public function publish($ak, $subject, AttributeValue $address)
    {
        $value = new Value();
        $value->address1 = $address->getAddress1();
        $value->address2 = $address->getAddress2();
        $value->address3 = $address->getAddress3();
        $value->city = $address->getCity();
        $value->country = $address->getCountry();
        $value->state_province = $address->getStateProvince();
        $value->postal_code = $address->getPostalCode();
        $subject->setAttribute($ak->getAttributeKeyHandle(), $value);
    }
}
