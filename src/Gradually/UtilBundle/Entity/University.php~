<?php

namespace Gradually\UtilBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * University
 *
 * @ORM\Table(name="universities", indexes={@ORM\Index(name="university_name", columns={"name"})})
 * @ORM\Entity
 */
class University
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \Gradually\UtilBundle\Entity\Degree
     *
     * @ORM\ManyToMany(targetEntity="Degree", inversedBy="universities")
     */
    private $degrees;

    /**
     * @var \Gradually\ProfileBundle\Entity\GraduateProfile
     *
     * @ORM\ManyToMany(targetEntity="\Gradually\ProfileBundle\Entity\GraduateProfile", inversedBy="universities"))
     */
    private $graduates;

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
     * @return University
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Constructor
     */
    public function __construct()
    {
        $this->degrees = new \Doctrine\Common\Collections\ArrayCollection();
        $this->graduates = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add degrees
     *
     * @param \Gradually\UtilBundle\Entity\Degree $degrees
     * @return University
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

    /**
     * Add graduates
     *
     * @param \Gradually\ProfileBundle\Entity\GraduateProfile $graduates
     * @return University
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
        return $this->name;
    }
}
