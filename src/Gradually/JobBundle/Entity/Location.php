<?php

namespace Gradually\JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table(name="locations")
 * @ORM\Entity
 */
class Location
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
     * @ORM\Column(name="postcode", type="string", length=5)
     */
    private $postcode;

    /**
     * @var point
     *
     * @ORM\Column(name="point", type="point")
     */
    private $point;

    /**
     * @ORM\ManyToOne(targetEntity="\Gradually\SearchBundle\Entity\JobSearch", inversedBy="location")
     */
    private $jobSearch;

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
     * Set postcode
     *
     * @param string $postcode
     * @return Location+
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string 
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set point
     *
     * @param \Gradually\LibraryBundle\Classes\Doctrine\Point $point
     * @return Location
     */
    public function setPoint(\Gradually\LibraryBundle\Classes\Doctrine\Point $point)
    {
        $this->point = $point;

        return $this;
    }

    /**
     * Get point
     *
     * @return \Gradually\LibraryBundle\Classes\Doctrine\Point 
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * Set jobSearch
     *
     * @param \Gradually\SearchBundle\Entity\JobSearch $jobSearch
     * @return Location
     */
    public function setJobSearch(\Gradually\SearchBundle\Entity\JobSearch $jobSearch = null)
    {
        $this->jobSearch = $jobSearch;

        return $this;
    }

    /**
     * Get jobSearch
     *
     * @return \Gradually\SearchBundle\Entity\JobSearch 
     */
    public function getJobSearch()
    {
        return $this->jobSearch;
    }
}
