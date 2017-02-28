<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportBatchTargetItems")
 */
class BatchTargetItem
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem", cascade={"persist", "remove"})
     **/
    protected $target_item;

    /**
     * @ORM\ManyToOne(targetEntity="Batch")
     **/
    protected $batch;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTargetItem()
    {
        return $this->target_item;
    }

    /**
     * @param mixed $target_item
     */
    public function setTargetItem($target_item)
    {
        $this->target_item = $target_item;
    }

    /**
     * @return mixed
     */
    public function getBatch()
    {
        return $this->batch;
    }

    /**
     * @param mixed $batch
     */
    public function setBatch($batch)
    {
        $this->batch = $batch;
    }
}
