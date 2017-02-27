<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey\TopicsFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AttributeKey\TopicsValidator;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey\TopicsPublisher;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;

/**
 * @Entity
 * @Table(name="MigrationImportTopicsAttributeKeys")
 */
class TopicsAttributeKey extends AttributeKey
{
    /**
     * @Column(type="string")
     */
    protected $tree_name = '';

    /**
     * @Column(type="string")
     */
    protected $node_path = '';

    /**
     * @return mixed
     */
    public function getTreeName()
    {
        return $this->tree_name;
    }

    /**
     * @param mixed $tree_name
     */
    public function setTreeName($tree_name)
    {
        $this->tree_name = $tree_name;
    }

    /**
     * @return mixed
     */
    public function getNodePath()
    {
        return $this->node_path;
    }

    /**
     * @param mixed $node_path
     */
    public function setNodePath($node_path)
    {
        $this->node_path = $node_path;
    }

    public function getType()
    {
        return 'topics';
    }

    public function getFormatter()
    {
        return new TopicsFormatter($this);
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return new TopicsValidator($batch);
    }

    public function getTypePublisher()
    {
        return new TopicsPublisher();
    }
}
