<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Command;

abstract class AbstractPagePublisherCommand extends PublisherCommand
{

    protected $pageId;

    public function __construct($batchId, $logId, $pageId)
    {
        parent::__construct($batchId, $logId);
        $this->pageId = $pageId;
    }

    /**
     * @return mixed
     */
    public function getPageId()
    {
        return $this->pageId;
    }

    /**
     * @param mixed $pageId
     */
    public function setPageId($pageId)
    {
        $this->pageId = $pageId;
    }



}