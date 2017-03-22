<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\SocialLinkValidator;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportSocialLinks")
 */
class SocialLink extends PublishableObject
{
    /**
     * @ORM\ManyToOne(targetEntity="SocialLinkObjectCollection")
     **/
    protected $collection;

    /**
     * @ORM\Column(type="string")
     */
    protected $service;

    /**
     * @ORM\Column(type="string")
     */
    protected $url;

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
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getPublisherValidator()
    {
        return new SocialLinkValidator($this);
    }

    public function __clone()
    {
        if ($this->id) {
            $this->id = null;
            $this->collection = null;
        }
    }
}
