<?php

namespace Gradually\UtilBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Degree
 *
 * @ORM\Table(name="degrees")
 * @ORM\Entity
 */
class Degree
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
     * @var \Gradually\UtilBundle\Entity\University
     *
     * @ORM\ManyToMany(targetEntity="University", mappedBy="degrees")
     */
    private $universities;

    /**
     * @var \Gradually\UtilBundle\Entity\DegreeLevel
     *
     * @ORM\ManyToMany(targetEntity="DegreeLevel", inversedBy="degrees")
     */
    private $levels;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->universities = new \Doctrine\Common\Collections\ArrayCollection();
        $this->graduates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->levels = new \Doctrine\Common\Collections\ArrayCollection(); 
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

    /**
     * Add universities
     *
     * @param \Gradually\UtilBundle\Entity\University $universities
     * @return Degree
     */
    public function addUniversity(\Gradually\UtilBundle\Entity\University $universities)
    {
        $this->universities[] = $universities;

        return $this;
    }

    /**
     * Remove universities
     *
     * @param \Gradually\UtilBundle\Entity\University $universities
     */
    public function removeUniversity(\Gradually\UtilBundle\Entity\University $universities)
    {
        $this->universities->removeElement($universities);
    }

    /**
     * Get universities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUniversities()
    {
        return $this->universities;
    }

    /**
     * Add graduates
     *
     * @param \Gradually\ProfileBundle\Entity\GraduateProfile $graduates
     * @return Degree
     */
    public function addGraduate(\Gradually\ProfileBundle\Entity\GraduateProfile $graduates)
    {
        $this->graduates[] = $graduates;

        return $this;
    }

    /**
     * Remove graduates
     *
     * @param \Gradually\ProfileBundle\Entity\GraduateProfile $graduates
     */
    public function removeGraduate(\Gradually\ProfileBundle\Entity\GraduateProfile $graduates)
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

    public function __toString()
    {
        return $this->title;
    }    

    /**
     * Add level
     *
     * @param \Gradually\UtilBundle\Entity\DegreeLevel $level
     * @return Degree
     */
    public function addLevel(\Gradually\UtilBundle\Entity\DegreeLevel $level)
    {
        $this->levels[] = $level;

        return $this;
    }

    /**
     * Remove level
     *
     * @param \Gradually\UtilBundle\Entity\DegreeLevel $level
     */
    public function removeLevel(\Gradually\UtilBundle\Entity\DegreeLevel $level)
    {
        $this->levels->removeElement($level);
    }

    /**
     * Get levels
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLevels()
    {
        return $this->levels;
    }
}
