<?php

namespace Gradually\UtilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JobTitleTag
 *
 * @ORM\Table(name="job_title_tags")
 * @ORM\Entity
 */
class JobTitleTag
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
     * @ORM\ManyToMany(targetEntity="GraduateUser", inversedBy="jobTitleTags"))
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
     * Set title
     *
     * @param string $title
     * @return JobTitleTag
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
        $this->graduates = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add graduates
     *
     * @param GraduateUser $graduates
     * @return JobTitleTag
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
