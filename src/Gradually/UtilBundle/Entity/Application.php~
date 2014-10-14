<?php

namespace Gradually\UtilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application
 *
 * @ORM\Table(name="applications")
 * @ORM\Entity(repositoryClass="Gradually\UtilBundle\Repository\ApplicationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Application
{
    const STATUS_SENT = 'SENT';
    const STATUS_RECEIVED = 'RECEIVED';
    const STATUS_SHORTLISTED = 'SHORTLISTED';
    const STATUS_DECLINED = 'DECLINED';
    const STATUS_INTERVIEW = 'INTERVIEW';
    const STATUS_OFFER = 'OFFER';
    const STATUS_OFFER_ACCEPTED = 'OFFER_ACCEPTED';
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
     * @ORM\Column(name="coverNote", type="text", nullable=true)
     */
    private $coverNote;

    /**
     * @var \Gradually\UtilBundle\Entity\GraduateUser
     *
     * @ORM\ManyToOne(targetEntity="\Gradually\UtilBundle\Entity\GraduateUser", inversedBy="applications")
     */
    private $graduate;

    /**
     * @var \Gradually\UtilBundle\Entity\Job
     *
     * @ORM\ManyToOne(targetEntity="\Gradually\UtilBundle\Entity\Job", inversedBy="applications")
     */
    private $job;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=32)
     */
    private $status;

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
     * Set coverNote
     *
     * @param string $coverNote
     * @return Application
     */
    public function setCoverNote($coverNote)
    {
        $this->coverNote = $coverNote;

        return $this;
    }

    /**
     * Get coverNote
     *
     * @return string 
     */
    public function getCoverNote()
    {
        return $this->coverNote;
    }

    /**
     * Set graduate
     *
     * @param GraduateUser $graduate
     * @return Application
     */
    public function setGraduate(GraduateUser $graduate = null)
    {
        $this->graduate = $graduate;

        return $this;
    }

    /**
     * Get graduate
     *
     * @return GraduateUser 
     */
    public function getGraduate()
    {
        return $this->graduate;
    }

    /**
     * Set job
     *
     * @param Job $job
     * @return Application
     */
    public function setJob(Job $job = null)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return \Gradually\JobBundle\Entity\Job 
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Application
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @ORM\PrePersist
     */
    public function initStatus()
    {
        $this->status = self::STATUS_SENT;
    }
}
