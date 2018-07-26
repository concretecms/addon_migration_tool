<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler;

use Concrete\Core\Page\Type\Type;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreatePageStructureCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreatePageStructureCommandHandler extends AbstractPageCommandHandler
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $command = $this->command;
        /**
         * @var $command CreatePageStructureCommand
         */
        $page = $this->getPage($command->getPageId());
        $logger->logPublishStarted($page);

        $batchParent = $this->getBatchParentPage($batch);

        $data = array();

        $ui = $this->getTargetItem($batch, 'user', $page->getUser());
        if ($ui != '') {
            $data['uID'] = $ui->getUserID();
        } else {
            $data['uID'] = USER_SUPER_ID;
        }
        $cDatePublic = $page->getPublicDate();
        if ($cDatePublic) {
            $data['cDatePublic'] = $cDatePublic;
        }

        $type = $this->getTargetItem($batch, 'page_type', $page->getType());
        if ($type) {
            $data['ptID'] = $type->getPageTypeID();
        }
        $template = $this->getTargetItem($batch, 'page_template', $page->getTemplate());
        if (is_object($template)) {
            $data['pTemplateID'] = $template->getPageTemplateID();
        }
        if ($page->getPackage()) {
            $pkg = \Package::getByHandle($page->getPackage());
            if (is_object($pkg)) {
                $data['pkgID'] = $pkg->getPackageID();
            }
        }

        // TODO exception if parent not found
        if ($page->getBatchPath() != '') {
            $parent = $this->ensureParentPageExists($batch, $page);
        } else {
            $parent = $batchParent;
        }

        $data['name'] = $page->getName();
        $data['cDescription'] = $page->getDescription();
        $data['cHandle'] = substr($page->getBatchPath(), strrpos($page->getBatchPath(), '/') + 1);

        $newPage = $parent->add($type, $data);
        $logger->logPublishComplete($page, $newPage);
    }
}
