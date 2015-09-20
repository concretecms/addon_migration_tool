<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class BatchValidator
{
    protected $batch;
    protected $messageCollection;
    protected $pages = array();

    public function __construct(Batch $batch)
    {
        $this->batch = $batch;
        $this->messageCollection = new MessageCollection();
        foreach($this->batch->getPages() as $page) {
            $validator = $page->getValidator();
            $messages = $validator->validate($page);
            $this->pages[$page->getID()] = $messages;
            foreach($messages as $message) {
                $this->messageCollection->add($message);
            }
        }
    }

    public function getMessageCollection()
    {
        return $this->messageCollection;
    }

    /**
     * @return Batch
     */
    public function getBatch()
    {
        return $this->batch;
    }

    /**
     * @param Batch $batch
     */
    public function setBatch($batch)
    {
        $this->batch = $batch;
    }

    public function validatePage(Page $page)
    {
        return $this->pages[$page->getID()];
    }

    public function getFormatter()
    {
        return new BatchMessageCollectionFormatter($this->messageCollection);
    }

}