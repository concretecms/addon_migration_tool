<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Validation\BannedWord\BannedWord;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;

defined('C5_EXECUTE') or die('Access Denied.');

class CreateBannedWordsRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch)
    {
        $words = $batch->getObjectCollection('banned_word');

        if (!$words) {
            return;
        }

        foreach ($words->getWords() as $word) {
            if (!$word->getPublisherValidator()->skipItem()) {
                BannedWord::add(str_rot13($word->getWord()));
            }
        }
    }
}
