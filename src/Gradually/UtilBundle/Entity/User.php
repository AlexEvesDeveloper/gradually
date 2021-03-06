<?php

namespace Gradually\UtilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"graduate" = "GraduateUser", "recruiter" = "RecruiterUser", "admin" = "AdminUser"})
 * @ORM\Entity()
 *
 * @ExclusionPolicy("all")
 */
abstract class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=60, unique=true)
     */
    private $username;

   /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=256)
     *
     * @Assert\Length(min="6")
     * @Assert\NotBlank
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=60)
     *
     * @Assert\Email
     * @Assert\NotBlank
     *
     * @Expose
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     */
    private $roles;

    /**
     * @ORM\OneToOne(targetEntity="ProfileImage", mappedBy="user", cascade={"persist", "remove"})
     */
    private $image;

    /**
     * @ORM\Column(name="completed_welcome_wizard", type="boolean")
     */
    private $completedWelcomeWizard;

    const TYPE_ADMIN = 'ADMIN';
    const TYPE_GRADUATE = 'GRADUATE';
    const TYPE_RECRUITER = 'RECRUITER';

    abstract public function getType();

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->isActive = true;
        $this->completedWelcomeWizard = false;
        $this->roles = new ArrayCollection();
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
     * Set username
     *
     * @param string $username
     * @return GraduateUser
     */
    public function setUsername($username)
    {
        $this->username = $username;
 
        return $this;
    }
 
    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

   /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    /**
     * Add roles
     *
     * @param Role $roles
     * @return User
     */
    public function addRole(Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param Role $roles
     */
    public function removeRole(Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @inheritDoc
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function isEnabled()
    {
        return $this->isActive;
    }


    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password
        ) = unserialize($serialized);
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set ProfileImage
     *
     * @param ProfileImage $profileImage
     * @return User
     */
    public function setProfileImage(ProfileImage $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get ProfileImage
     *
     * @return ProfileImage 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set image
     *
     * @param ProfileImage $image
     * @return User
     */
    public function setImage(ProfileImage $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Set completedWelcomeWizard
     *
     * @param boolean $completedWelcomeWizard
     * @return User
     */
    public function setCompletedWelcomeWizard($completedWelcomeWizard)
    {
        $this->completedWelcomeWizard = $completedWelcomeWizard;

        return $this;
    }

    /**
     * Get completedWelcomeWizard
     *
     * @return boolean 
     */
    public function getCompletedWelcomeWizard()
    {
        return $this->completedWelcomeWizard;
    }
}
