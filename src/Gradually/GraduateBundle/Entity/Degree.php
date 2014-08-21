<?php

namespace Gradually\GraduateBundle\Entity;

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
     * @var \Gradually\GraduateBundle\Entity\University
     *
     * @ORM\ManyToMany(targetEntity="University", mappedBy="degrees")
     */
    private $universities;

     /**
      * @var \Gradually\ProfileBundle\Entity\GraduateProfile
      *
      * @ORM\ManyToMany(targetEntity="\Gradually\ProfileBundle\Entity\GraduateProfile", mappedBy="degrees")
      */
     private $graduates;

    /**
     * @var string
     *
     * @ORM\Column(name="level", type="string", length=128)
     */
    private $level;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="yearAttained", type="datetime")
     */
    private $yearAttained;


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
     * Set level
     *
     * @param string $level
     * @return Degree
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set yearAttained
     *
     * @param \DateTime $yearAttained
     * @return Degree
     */
    public function setYearAttained($yearAttained)
    {
        $this->yearAttained = $yearAttained;

        return $this;
    }

    /**
     * Get yearAttained
     *
     * @return \DateTime 
     */
    public function getYearAttained()
    {
        return $this->yearAttained;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->universities = new \Doctrine\Common\Collections\ArrayCollection();
        $this->graduates = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add universities
     *
     * @param \Gradually\GraduateBundle\Entity\University $universities
     * @return Degree
     */
    public function addUniversity(\Gradually\GraduateBundle\Entity\University $universities)
    {
        $this->universities[] = $universities;

        return $this;
    }

    /**
     * Remove universities
     *
     * @param \Gradually\GraduateBundle\Entity\University $universities
     */
    public function removeUniversity(\Gradually\GraduateBundle\Entity\University $universities)
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
}
