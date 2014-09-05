<?php
 
namespace Gradually\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection; 
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
      * @ORM\Column(name="first_name", type="string", length=64)
      */
     protected $firstName;
 
     /**
      * @var string
      *
      * @ORM\Column(name="last_name", type="string", length=64)
      */
     protected $lastName;

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

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return parent::TYPE_GRADUATE;
    }
}
