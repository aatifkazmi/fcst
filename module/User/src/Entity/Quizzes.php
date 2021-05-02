<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quizzes
 *
 * @ORM\Table(name="quizzes", indexes={@ORM\Index(name="fk_quizzes_courses1_idx", columns={"courses_id"})})
 * @ORM\Entity(repositoryClass="\User\Repository\QuizzesRepository")
 * 
 */
class Quizzes
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
     * @ORM\Column(name="instructions", type="text", length=65535, precision=0, scale=0, nullable=false, unique=false)
     */
    private $instructions;

    /**
     * @var \User\Entity\Courses
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\Courses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="courses_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $courses;


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
     * Set instructions
     *
     * @param string $instructions
     *
     * @return Quizzes
     */
    public function setInstructions($instructions)
    {
        $this->instructions = $instructions;

        return $this;
    }

    /**
     * Get instructions
     *
     * @return string
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * Set courses
     *
     * @param \User\Entity\Courses $courses
     *
     * @return Quizzes
     */
    public function setCourses(\User\Entity\Courses $courses = null)
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
}

