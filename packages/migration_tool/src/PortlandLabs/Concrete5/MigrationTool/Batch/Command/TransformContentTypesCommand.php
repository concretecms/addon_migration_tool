<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Command;

use Concrete\Core\Foundation\Queue\Batch\Command\BatchableCommandInterface;
use League\Tactician\Bernard\QueueableCommand;

class TransformContentTypesCommand implements BatchableCommandInterface
{

    protected $batchId;

    protected $mapper;

    protected $entity;

    protected $transformer;

    public function __construct($batchId, $entity, $mapper, $transformer)
    {
        $this->batchId = $batchId;
        $this->mapper = $mapper;
        $this->entity = $entity;
        $this->transformer = $transformer;
    }

    /**
     * @return mixed
     */
    public function getBatchId()
    {
        return $this->batchId;
    }

    /**
     * @param mixed $batchId
     */
    public function setBatchId($batchId)
    {
        $this->batchId = $batchId;
    }

    /**
     * @return mixed
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * @param mixed $mapper
     */
    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return mixed
     */
    public function getTransformer()
    {
        return $this->transformer;
    }

    /**
     * @param mixed $transformer
     */
    public function setTransformer($transformer)
    {
        $this->transformer = $transformer;
    }



    public function getBatchHandle()
    {
        return 'transform_content_types';
    }

}