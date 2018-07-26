<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler;

use Concrete\Core\Attribute\Key\Category;
use Concrete\Core\Entity\Express\Entry\ManyAssociation;
use Concrete\Core\Entity\Express\Entry\OneAssociation;
use Concrete\Core\Entity\Express\ManyToManyAssociation;
use Concrete\Core\Entity\Express\OneToManyAssociation;
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

class AssociateExpressEntryCommandHandler extends AbstractHandler
{

    public function getEntry($id)
    {
        $r = $this->entityManager->getRepository(Entry::class);
        return $r->findOneById($id);
    }

    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $db = \Database::connection();

        /**
         * @var $command CreateExpressEntryCommand
         */
        $command = $this->command;
        $em = $this->entityManager;

        $entry = $this->getEntry($command->getEntryId());

        // First, given the entry, look in the current log to see where that entry ID was published to
        $publishedEntryID = $db->fetchColumn('select exEntryID from MigrationPublisherLogExpressEntries ee inner join MigrationPublisherLogObjects lo on ee.id = lo.id inner join MigrationPublisherLogEntries le on lo.entry_id = le.id where log_id = ? and original_id = ?', [$logger->getLog()->getID(), $entry->getID()]);

        if ($publishedEntryID) {
            $publishedEntry = \Express::getEntry($publishedEntryID);
            if ($publishedEntry) {

                foreach($entry->getAssociations() as $association) {

                    $entityAssociation = $publishedEntry->getEntity()->getAssociation($association->getTarget());
                    if ($entityAssociation instanceof ManyToManyAssociation ||
                        $entityAssociation instanceof OneToManyAssociation) {
                        $publishedAssociation = new ManyAssociation();
                    } else {
                        $publishedAssociation = new OneAssociation();
                    }

                    $selectedEntries = array();
                    $entries = $association->getAssociatedEntries();

                    foreach($entries as $associatedEntry) {

                        $associatedEntryID = $db->fetchColumn('select exEntryID from MigrationImportExpressEntries mee inner join MigrationPublisherLogExpressEntries ee on mee.id = ee.original_id inner join MigrationPublisherLogObjects lo on ee.id = lo.id inner join MigrationPublisherLogEntries le on lo.entry_id = le.id where log_id = ? and importID = ?', [$logger->getLog()->getID(), $associatedEntry->getImportID()]);
                        if ($associatedEntryID) {
                            $associatedEntry = \Express::getEntry($associatedEntryID);
                            if ($associatedEntry) {
                                $selectedEntries[] = $associatedEntry;
                            }
                        }
                    }

                    $publishedAssociation->setSelectedEntries($selectedEntries);
                    $publishedAssociation->setAssociation($entityAssociation);
                    $publishedAssociation->setEntry($publishedEntry);
                    $em->persist($publishedAssociation);
                    $em->flush();
                }
            }
        }
    }

}
