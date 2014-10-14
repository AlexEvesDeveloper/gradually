<?php

namespace Gradually\UtilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JobValue
 *
 * @ORM\Table(name="job_values")
 * @ORM\Entity
 */
class JobTitle
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
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * @ORM\ManyToMany(targetEntity="GraduateUser", inversedBy="jobTitles"))
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
        $this->graduates = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set value
     *
     * @param string $value
     * @return JobValueTag
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
     * Constructor
     */
    public function __construct()
    {
        $this->graduates = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add graduates
     *
     * @param GraduateUser $graduates
     * @return JobValueTag
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
}
