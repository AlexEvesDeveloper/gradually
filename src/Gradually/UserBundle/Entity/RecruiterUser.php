<?php
 
namespace Gradually\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
 
/**
 * RecruiterUser
 *
 * @ORM\Entity
 */
class RecruiterUser extends User
{
     /**
      * @ORM\ManyToMany(targetEntity="GraduateUser", mappedBy="recruiters")
      */
     private $graduates;
 
     public function __construct()
     {
         parent::__construct();
         $this->graduates = new ArrayCollection();
     }

    /**
     * Add graduates
     *
     * @param \Gradually\UserBundle\Entity\GraduateUser $graduates
     * @return RecruiterUser
     */
    public function addGraduate(\Gradually\UserBundle\Entity\GraduateUser $graduates)
    {
        $this->graduates[] = $graduates;

        return $this;
    }

    /**
     * Remove graduates
     *
     * @param \Gradually\UserBundle\Entity\GraduateUser $graduates
     */
    public function removeGraduate(\Gradually\UserBundle\Entity\GraduateUser $graduates)
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
