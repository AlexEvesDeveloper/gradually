<?php
 
namespace Gradually\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection; 
use Doctrine\ORM\Mapping as ORM;

/**
 * GraduateUser
 *
 * @ORM\Entity
 */
class GraduateUser extends User
{
     /**
      * @var string
      *
      * @ORM\Column(name="firstName", type="string", length=64)
      */
     private $firstName;
 
     /**
      * @var string
      *
      * @ORM\Column(name="lastName", type="string", length=64)
      */
     private $lastName;

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return GraduateUser
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return GraduateUser
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }
}
