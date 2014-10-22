<?php

namespace Gradually\UtilBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * School
 *
 * @ORM\Table(name="schools")
 * @ORM\Entity()
 */
class School
{
    /**
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;
    
    /**
     * @ORM\OneToMany(targetEntity="Qualification", mappedBy="school"))
     */
    private $qualifications;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->qualifications = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set value
     *
     * @param string $value
     * @return School
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Add qualification
     *
     * @param Qualification $qualification
     * @return School
     */
    public function addQualification(Qualification $qualification)
    {
        $this->qualifications[] = $qualification;

        return $this;
    }

    /**
     * Remove qualification
     *
     * @param Qualification $qualification
     */
    public function removeQualification(Qualification $qualification)
    {
        $this->qualifications->removeElement($qualification);
    }

    /**
     * Get qualifications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQualifications()
    {
        return $this->qualifications;
    }
}
