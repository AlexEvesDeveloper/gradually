<?php

namespace Gradually\ProfileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profile
 *
 * @ORM\Table(name="profiles")
 * @ORM\Entity
 */
class Profile
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
     * @var \Gradually\UserBundle\Entity\User
     *
     * @ORM\OneToOne(targetEntity="\Gradually\UserBundle\Entity\User", mappedBy="profile")
     */
    private $user;

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
     * Set user
     *
     * @param \Gradually\UserBundle\Entity\User $user
     * @return Profile
     */
    public function setUser(\Gradually\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Gradually\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}