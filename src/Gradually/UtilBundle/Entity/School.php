<?php

namespace Gradually\UtilBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * School
 *
 * @ORM\Table(name="schools", indexes={@ORM\Index(name="school_name", columns={"name"})})
 * @ORM\Entity()
 */
class School
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
     * @ORM\ManyToMany(targetEntity="GraduateUser", inversedBy="schools"))
     */
    private $graduates;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->degrees = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return School
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
     * Add graduates
     *
     * @param GraduateUser $graduates
     * @return School
     */
    public function addGraduate(GraduateUser $graduates)
    {
        $this->graduates[] = $graduates;

        return $this;
    }

    /**
     * Remove graduates
     *
     * @param GraduateUser $graduates
     */
    public function removeGraduate(GraduateUser $graduates)
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
