<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\AttributeTypeValidator;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\BannedWordValidator;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\BlockTypeValidator;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\PageTemplateValidator;


/**
 * @Entity
 * @Table(name="MigrationImportBannedWords")
 */
class BannedWord implements PublishableInterface
{

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="BannedWordObjectCollection")
     **/
    protected $collection;

    /**
     * @Column(type="string")
     */
    protected $word;

    public function getPublisherValidator()
    {
        return new BannedWordValidator($this);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param mixed $collection
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return mixed
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * @param mixed $word
     */
    public function setWord($word)
    {
        $this->word = $word;
    }





}
