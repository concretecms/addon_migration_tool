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
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\User;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateUserCommand;
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

class CreateUserCommandHandler extends AbstractHandler
{

    public function getUser($id)
    {
        $r = $this->entityManager->getRepository(User::class);
        return $r->findOneById($id);
    }

    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $command = $this->command;
        /**
         * @var $command CreateUserCommand
         */
        $user = $this->getUser($command->getId());

        $logger->logPublishStarted($user);

        // First, create the user object
        $entity = new \Concrete\Core\Entity\User\User();
        $entity->setUserName($user->getName());
        $entity->setUserEmail($user->getEmail());
        $entity->setUserPassword(id(new Identifier())->getString(64));
        if ($user->getLanguage()) {
            $entity->setUserDefaultLanguage($user->getLanguage());
        }
        if ($user->getTimezone()) {
            $entity->setUserTimezone($user->getTimezone());
        }
        if ($user->getIsActive()) {
            $entity->setUserIsActive($user->getIsActive());
        }
        if ($user->getIsValidated()) {
            $entity->setUserIsValidated($user->getIsValidated());
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        $userInfo = $entity->getUserInfoObject();

        foreach ($user->getAttributes() as $attribute) {
            $ak = TargetItemList::getBatchTargetItem($batch, 'user_attribute', $attribute->getAttribute()->getHandle());
            if (is_object($ak)) {
                $value = $attribute->getAttribute()->getAttributeValue();
                $publisher = $value->getPublisher();
                $publisher->publish($batch, $ak, $userInfo, $value);
            }
        }

        // add groups
        foreach($user->getGroups() as $group) {
            $identifier = $group->getPath();
            if (!$identifier) {
                $identifier = '/' . $group->getName();
            }

            $group = TargetItemList::getBatchTargetItem($batch, 'user_group', $identifier);
            if (is_object($group)) {
                $uo = $userInfo->getUserObject();
                $uo->enterGroup($group);
            }
        }

        $logger->logPublishComplete($user, $entity);
    }

}
