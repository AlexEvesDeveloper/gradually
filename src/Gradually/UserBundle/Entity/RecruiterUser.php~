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
     * @var string
     *
     * @ORM\Column(name="company_name", type="string", length=128)
     */
    protected $companyName;

    /**
     * Set companyName
     *
     * @param string $companyName
     * @return RecruiterUser
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string 
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }
}
