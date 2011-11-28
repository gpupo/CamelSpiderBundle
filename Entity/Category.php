<?php

namespace Gpupo\CamelSpiderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Tree\Node;
/**
 * Gpupo\CamelSpiderBundle\Entity\Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Gpupo\CamelSpiderBundle\Entity\CategoryRepository")
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\Tree(type="nested")
 */
class Category implements Node
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="News", mappedBy="category")
     */
    private $newss;


    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;


    /**
     * Magic method to conver the object to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getNameIndented();
    }
    public function __construct()
    {
        $this->newss = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get name indented
     *
     * @return string
     */
    public function getNameIndented()
    {
        $repeat = $this->getLvl() == 0 ? 0 : $this->getLvl()-1;

        return str_repeat('- ', $repeat) . $this->getName();
    }

    /**
     * Add newss
     *
     * @param Gpupo\CamelSpiderBundle\Entity\News $newss
     */
    public function addNews(\Gpupo\CamelSpiderBundle\Entity\News $newss)
    {
        $this->newss[] = $newss;
    }

    /**
     * Get newss
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getNewss()
    {
        return $this->newss;
    }

    /**
     * Set lft
     *
     * @param integer $lft
     */
    public function setLft($lft)
    {
        $this->lft = $lft;
    }

    /**
     * Get lft
     *
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;
    }

    /**
     * Get lvl
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;
    }

    /**
     * Get rgt
     *
     * @return integer
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set root
     *
     * @param integer $root
     */
    public function setRoot($root)
    {
        $this->root = $root;
    }

    /**
     * Get root
     *
     * @return integer
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set parent
     *
     * @param Gpupo\CamelSpiderBundle\Entity\Category $parent
     */
    public function setParent($parent)
    {
        if (null !== $parent && !$parent instanceof \Gpupo\CamelSpiderBundle\Entity\Category) {
            throw new \Exception('parent must be null or instance of Gpupo\CamelSpiderBundle\Entity\Category');
        }
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return Gpupo\CamelSpiderBundle\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param Gpupo\CamelSpiderBundle\Entity\Category $children
     */
    public function addCategory(\Gpupo\CamelSpiderBundle\Entity\Category $children)
    {
        $this->children[] = $children;
    }

    /**
     * Get children
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Check if Category has parent category
     *
     * @return boolean
     */
    public function hasParent()
    {
        return null === $this->parent ? false : true;
    }

    /**
     * Get array of objects of path
     *
     * @return array
     */
    public function getPath()
    {
        $node = $this;
        $path = array();
        do {
            $path[] = $node;
            $node = $node->getParent();
        } while (null !== $node && $this->hasParent() && $node->getLvl() != 0);

        return array_reverse($path);
    }

    /**
     * Get array of path names
     *
     * @return array
     */
    public function getPathNames()
    {
        $pathNames = array();
        foreach ($this->getPath() as $path)
        {
            $pathNames[] = $path->getName();
        }
        return $pathNames;
    }

    /**
     * Return path names in string format (breadcrumb)
     *
     * @return string
     */
    public function getPathNamesString()
    {
        return implode(' -> ', $this->getPathNames());
    }

}
