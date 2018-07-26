<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler;

use Concrete\Core\Attribute\Key\Category;
use Concrete\Core\Utility\Service\Identifier;
use PortlandLabs\CalendarImport\Entity\Import\Event;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Entry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\EntryAssociation;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\User;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateExpressEntryCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\AbstractPageAction;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\AbstractPageRoutine;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\RoutineActionInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler\RoutineInterface;
use PortlandLabs\CalendarImport\Entity\Import\BatchSettings;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\Page as LogPage;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateExpressEntryCommandHandler extends AbstractHandler
{

    public function getEntry($id)
    {
        $r = $this->entityManager->getRepository(Entry::class);
        return $r->findOneById($id);
    }

    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        /**
         * @var $command CreateExpressEntryCommand
         */
        $command = $this->command;

        $entry = $this->getEntry($command->getEntryId());

        $logger->logPublishStarted($entry);

        $publishedEntity = \Express::getObjectByHandle($entry->getEntity());
        $publishedEntry = new \Concrete\Core\Entity\Express\Entry();
        $publishedEntry->setEntity($publishedEntity);

        $this->entityManager->persist($publishedEntry);
        $this->entityManager->flush();

        $mappers = \Core::make('migration/manager/mapping');

        foreach ($entry->getAttributes() as $attribute) {
            $mapper = $mappers->driver('express_attribute');
            $list = $mappers->createTargetItemList($batch, $mapper);
            $item = new Item($entry->getEntity() . '|' . $attribute->getAttribute()->getHandle());
            $targetItem = $list->getSelectedTargetItem($item);
            if (!($targetItem instanceof UnmappedTargetItem || $targetItem instanceof IgnoredTargetItem)) {
                $ak = $mapper->getTargetItemContentObject($targetItem);
                if (is_object($ak)) {
                    $value = $attribute->getAttribute()->getAttributeValue();
                    $publisher = $value->getPublisher();
                    $publisher->publish($batch, $ak, $publishedEntry, $value);
                }
            }
        }

        $logger->logPublishComplete($entry, $publishedEntry);
    }

}
