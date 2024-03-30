<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Block;

use Concrete\Core\Database\Connection\Connection;
use Concrete\Core\Legacy\BlockRecord;
use Concrete\Core\Support\Facade\Application;
use Doctrine\DBAL\Types\Type;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\BlockValue;
use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardPublisher implements PublisherInterface
{
    /** @var Connection */
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function publish(Batch $batch, $bt, Page $page, $area, BlockValue $value)
    {
        $records = $value->getRecords();
        $inspector = \Core::make('migration/import/value_inspector', array($batch));
        if (count($records) == 1) {
            $data = array();
            foreach ($records[0]->getData() as $key => $value) {
                $result = $inspector->inspect($value);
                $data[$key] = $result->getReplacedValue();
            }
            $b = $page->addBlock($bt, $area, $data);
        } elseif (count($records) > 1) {
            foreach ($records as $record) {
                if (strcasecmp($record->getTable(), $bt->getController()->getBlockTypeDatabaseTable()) == 0) {
                    // This is the data record.
                    $data = array();
                    foreach ($record->getData() as $key => $value) {
                        $result = $inspector->inspect($value);
                        $data[$key] = $result->getReplacedValue();
                    }
                    $b = $page->addBlock($bt, $area, $data);
                }
            }
            // Now we import the OTHER records.
            if ($b) {
                $sm = $this->connection->getSchemaManager();
                foreach ($records as $record) {
                    if (strcasecmp($record->getTable(), $bt->getController()->getBlockTypeDatabaseTable()) != 0) {
                        $columns = $sm->listTableColumns($record->getTable());
                        $aar = new BlockRecord($record->getTable());
                        $aar->bID = $b->getBlockID();
                        foreach ($record->getData() as $key => $value) {
                            $result = $inspector->inspect($value);
                            $value = $result->getReplacedValue();
                            foreach ($columns as $column) {
                                if ($column->getName() !== $key || $column->getType()->getName() !== Type::INTEGER) {
                                    continue;
                                }

                                $value = ($column->getNotnull() || $column !== null) ? (int) $value : null;
                            }
                            $aar->{$key} = $value;
                        }
                        $aar->Save();
                    }
                }
            }
        } else {
            $b = $page->addBlock($bt, $area, array());
        }

        return $b;
    }
}
