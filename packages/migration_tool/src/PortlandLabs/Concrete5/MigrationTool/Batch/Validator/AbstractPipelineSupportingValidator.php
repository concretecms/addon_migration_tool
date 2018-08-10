<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;

abstract class AbstractPipelineSupportingValidator implements ValidatorInterface
{

    protected $stages = [];

    /**
     * @var PipelineBuilder
     */
    protected $builder;

    public function __construct()
    {
        $this->builder = new PipelineBuilder();
    }

    public function addPipelineStage(StageInterface $stage)
    {
        $this->builder->add($stage);
    }

    protected function getValidatorResult(ValidatorSubjectInterface $subject)
    {
        return new ValidatorResult($subject);
    }


    /**
     * @param ValidatorSubjectInterface $subject
     * @return ValidatorResultInterface
     */
    public function validate(ValidatorSubjectInterface $subject)
    {
        $pipeline = $this->builder->build();
        return $pipeline->process($this->getValidatorResult($subject));
    }

}
