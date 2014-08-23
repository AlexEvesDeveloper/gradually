<?php

namespace Gradually\UtilBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * DegreeLevel
 *
 * @ORM\Table(name="degreelevels")
 * @ORM\Entity
 */
class DegreeLevel
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
     * @ORM\Column(name="title", type="string", length=64)
     */
    private $title;

    /**
     * @var \Gradually\UtilBundle\Entity\Degree
     *
     * @ORM\ManyToMany(targetEntity="Degree", mappedBy="levels")
     */
    private $degrees;

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
     * @return DegreeLevel
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
     * Constructor
     */
    public function __construct()
    {
        $this->degrees = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add degrees
     *
     * @param \Gradually\UtilBundle\Entity\Degree $degrees
     * @return DegreeLevel
     */
    public function addDegree(\Gradually\UtilBundle\Entity\Degree $degrees)
    {
        $this->degrees[] = $degrees;

        return $this;
    }

    /**
     * Remove degrees
     *
     * @param \Gradually\UtilBundle\Entity\Degree $degrees
     */
    public function removeDegree(\Gradually\UtilBundle\Entity\Degree $degrees)
    {
        $this->degrees->removeElement($degrees);
    }

    /**
     * Get degrees
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDegrees()
    {
        return $this->degrees;
    }

    public function __toString()
    {
        return $this->title;
    }
}
