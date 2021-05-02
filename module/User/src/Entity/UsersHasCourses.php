<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersHasCourses
 *
 * @ORM\Table(name="users_has_courses", indexes={@ORM\Index(name="fk_users_has_courses_courses1_idx", columns={"courses_id"}), @ORM\Index(name="fk_users_has_courses_users1_idx", columns={"users_id"})})
 * @ORM\Entity
 */
class UsersHasCourses
{
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=45, precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $status;
    /**
     * @var string
     *
     * @ORM\Column(name="score", type="string")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $score;
    /**
     * @var string
     *
     * @ORM\Column(name="qualified_date", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $qualified_date;

    /**
     * @var \User\Entity\Courses
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User\Entity\Courses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="courses_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $courses;

    /**
     * @var \User\Entity\Users
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $users;

    /**
     * Set status
     *
     * @param string $status
     *
     * @return UsersHasCourses
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
     * Set courses
     *
     * @param \User\Entity\Courses $courses
     *
     * @return UsersHasCourses
     */
    public function setCourses(\User\Entity\Courses $courses)
    {
        $this->courses = $courses;

        return $this;
    }

    /**
     * Get courses
     *
     * @return \User\Entity\Courses
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Set users
     *
     * @param \User\Entity\Users $users
     *
     * @return UsersHasCourses
     */
    public function setUsers(\User\Entity\Users $users)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return \User\Entity\Users
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set score
     *
     * @param string $score
     *
     * @return UsersHasCourses
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return string
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set status
     *
     * @param string $qualifiedDate
     *
     * @return UsersHasCourses
     */
    public function setQualifiedDate($qualifiedDate)
    {
        $this->qualified_date = $qualifiedDate;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getQualifiedDate()
    {
        return $this->qualified_date;
    }
}

