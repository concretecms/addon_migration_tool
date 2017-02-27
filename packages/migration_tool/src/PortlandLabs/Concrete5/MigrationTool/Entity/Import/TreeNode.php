<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

/**
 * @Entity
 * @Table(name="MigrationImportTreeNodes")
 */
class TreeNode
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Tree")
     **/
    protected $tree;

    /**
     * @Column(type="string", nullable=true)
     */
    protected $title;

    /**
     * @Column(type="string")
     */
    protected $type;

    /**
     * @ManyToOne(targetEntity="TreeNode", inversedBy="children", cascade={"persist", "remove"})
     * @JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $parent;

    /**
     * @OneToMany(targetEntity="TreeNode", mappedBy="parent")
     */
    protected $children;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTree()
    {
        return $this->tree;
    }

    /**
     * @param mixed $tree
     */
    public function setTree($tree)
    {
        $this->tree = $tree;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

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
    public function getChildren()
    {
        return $this->children;
    }
}
