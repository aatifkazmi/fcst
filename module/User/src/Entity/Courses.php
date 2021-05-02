<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Courses
 *
 * @ORM\Table(name="courses")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="\User\Repository\CoursesRepository")
 */

class Courses
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text", length=65535, precision=0, scale=0, nullable=false, unique=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, precision=0, scale=0, nullable=false, unique=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="cpd_units", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $cpdUnits;

    /**
     * @var integer
     *
     * @ORM\Column(name="approved_by_iirsm", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $approvedByIirsm;

    /**
     * @var string
     *
     * @ORM\Column(name="duration", type="string", length=45, precision=0, scale=0, nullable=false, unique=false)
     */
    private $duration;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User\Entity\Users", mappedBy="courses")
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Courses
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
     * Set description
     *
     * @param string $description
     *
     * @return Courses
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set cpdUnits
     *
     * @param integer $cpdUnits
     *
     * @return Courses
     */
    public function setCpdUnits($cpdUnits)
    {
        $this->cpdUnits = $cpdUnits;

        return $this;
    }

    /**
     * Get cpdUnits
     *
     * @return integer
     */
    public function getCpdUnits()
    {
        return $this->cpdUnits;
    }

    /**
     * Set approvedByIirsm
     *
     * @param integer $approvedByIirsm
     *
     * @return Courses
     */
    public function setApprovedByIirsm($approvedByIirsm)
    {
        $this->approvedByIirsm = $approvedByIirsm;

        return $this;
    }

    /**
     * Get approvedByIirsm
     *
     * @return integer
     */
    public function getApprovedByIirsm()
    {
        return $this->approvedByIirsm;
    }

    /**
     * Set duration
     *
     * @param string $duration
     *
     * @return Courses
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Add user
     *
     * @param \User\Entity\Users $user
     *
     * @return Courses
     */
    public function addUser(\User\Entity\Users $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \User\Entity\Users $user
     */
    public function removeUser(\User\Entity\Users $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}

