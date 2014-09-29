<?php

namespace Gradually\SearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecruiterSearch
 *
 * @ORM\Table(name="recruiter_searches")
 * @ORM\Entity
 */
class RecruiterSearch
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
     * @ORM\OneToOne(targetEntity="\Gradually\UserBundle\Entity\RecruiterUser")
     */
    private $recruiter;

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
     * Set recruiter
     *
     * @param \Gradually\UserBundle\Entity\RecruiterUser $recruiter
     * @return RecruiterSearch
     */
    public function setUniversity(\Gradually\UserBundle\Entity\RecruiterUser $recruiter = null)
    {
        $this->recruiter = $recruiter;

        return $this;
    }

    /**
     * Get recruiter
     *
     * @return \Gradually\UserBundle\Entity\RecruiterUser 
     */
    public function getRecruiter()
    {
        return $this->recruiter;
    }

    /**
     * Set recruiter
     *
     * @param \Gradually\UserBundle\Entity\RecruiterUser $recruiter
     * @return RecruiterSearch
     */
    public function setRecruiter(\Gradually\UserBundle\Entity\RecruiterUser $recruiter = null)
    {
        $this->recruiter = $recruiter;

        return $this;
    }
}
