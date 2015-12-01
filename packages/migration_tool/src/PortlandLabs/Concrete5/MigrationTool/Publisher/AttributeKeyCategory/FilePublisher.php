<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKeyCategory;

use Concrete\Core\Attribute\Key\FileKey;
use Concrete\Core\Package\Package;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class FilePublisher implements PublisherInterface
{
    public function publish(AttributeKey $ak, Package $pkg = null)
    {
        $key = FileKey::add($ak->getType(),
            array(
                'akHandle' => $ak->getHandle(),
                'akName' => $ak->getName(),
                'akIsInternal' => $ak->getIsInternal(),
                'akIsSearchableIndexed' => $ak->getIsIndexed(),
                'akIsSearchable' => $ak->getIsSearchable(),
        ), $pkg);

        return $key;
    }
}
