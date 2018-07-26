<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler;

use Concrete\Core\Validation\BannedWord\BannedWord;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateBannedWordsCommandHandler extends AbstractHandler
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $words = $batch->getObjectCollection('banned_word');

        if (!$words) {
            return;
        }

        foreach ($words->getWords() as $word) {
            if (!$word->getPublisherValidator()->skipItem()) {
                $logger->logPublishStarted($word);
                BannedWord::add(str_rot13($word->getWord()));
                $logger->logPublishComplete($word);
            } else {
                $logger->logSkipped($word);
            }
        }
    }
}
