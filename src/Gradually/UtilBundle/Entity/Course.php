<?php

namespace Gradually\UtilBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Degree
 *
 * @ORM\Table(name="courses")
 * @ORM\Entity
 */
class Course
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="GraduateUser", inversedBy="schools"))
     */
    private $graduates;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->graduates = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Degree
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function __toString()
    {
        return $this->title;
    }    

    /**
     * Add graduates
     *
     * @param \Gradually\UtilBundle\Entity\GraduateUser $graduates
     * @return Course
     */
    public function addGraduate(\Gradually\UtilBundle\Entity\GraduateUser $graduates)
    {
        $this->graduates[] = $graduates;

        return $this;
    }

    /**
     * Remove graduates
     *
     * @param \Gradually\UtilBundle\Entity\GraduateUser $graduates
     */
    public function removeGraduate(\Gradually\UtilBundle\Entity\GraduateUser $graduates)
    {
        $this->graduates->removeElement($graduates);
    }

    /**
     * Get graduates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGraduates()
    {
        return $this->graduates;
    }
}
