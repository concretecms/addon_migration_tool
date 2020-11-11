<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\Block;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StandardBlockDataRecord;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StandardBlockValue;
use PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\ImporterInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardImporter implements ImporterInterface
{
    public function createBlockValueObject()
    {
        return new StandardBlockValue();
    }

    /**
     * Parse post content of WordPress then make block data record for content block.
     * WordPress content doesn't have paragraph elements.
     * You can replace double line breaks with paragraph by including `wp-includes/formatting.php` .
     *
     * @see https://developer.wordpress.org/reference/functions/wpautop/
     *
     * @example
     * ```
     * // application/bootstrap/autoload.php
     * if (!function_exists('wpautop')) {
     *     include '/path/to/WordPress/wp-includes/formatting.php';
     * }
     * ```
     */
    public function parse(\SimpleXMLElement $node)
    {
        $content = $node->children('http://purl.org/rss/1.0/modules/content/');
        $encoded = (string) $content->encoded;
        if (function_exists('wpautop')) {
            $encoded = wpautop($encoded);
        }
        $recordData = array('content' => $encoded);

        $value = $this->createBlockValueObject();

        $r = new StandardBlockDataRecord();
        $r->setTable('btContentLocal');
        $r->setData($recordData);
        $r->setValue($value);
        $r->setPosition(1);

        $value->getRecords()->add($r);

        return $value;
    }
}
