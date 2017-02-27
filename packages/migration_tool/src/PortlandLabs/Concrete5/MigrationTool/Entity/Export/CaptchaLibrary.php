<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Export;

/**
 * @Entity
 */
class CaptchaLibrary extends ExportItem
{
    /**
     * @Column(type="string", nullable=false)
     */
    protected $handle;

    /**
     * @return mixed
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @param mixed $item_id
     */
    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

    public function getItemIdentifier()
    {
        return $this->getHandle();
    }
}
