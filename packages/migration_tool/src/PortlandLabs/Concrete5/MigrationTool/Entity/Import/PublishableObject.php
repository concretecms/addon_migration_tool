<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;
use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportBatchPublishableObjects")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 */
abstract class PublishableObject implements PublishableInterface
{

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


}
