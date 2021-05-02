<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Questions
 *
 * @ORM\Table(name="questions", indexes={@ORM\Index(name="fk_questions_quizzes1_idx", columns={"quizzes_id"})})
 * @ORM\Entity
 */
class Questions
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
     * @ORM\Column(name="question", type="text", length=65535, precision=0, scale=0, nullable=false, unique=false)
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="answers", type="text", length=65535, precision=0, scale=0, nullable=false, unique=false)
     */
    private $answers;

    /**
     * @var string
     *
     * @ORM\Column(name="correct_answer_key", type="text", length=65535, precision=0, scale=0, nullable=false, unique=false)
     */
    private $correctAnswerKey;

    /**
     * @var \User\Entity\Quizzes
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\Quizzes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="quizzes_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $quizzes;


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
     * Set question
     *
     * @param string $question
     *
     * @return Questions
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set answers
     *
     * @param string $answers
     *
     * @return Questions
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;

        return $this;
    }

    /**
     * Get answers
     *
     * @return string
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Set correctAnswerKey
     *
     * @param string $correctAnswerKey
     *
     * @return Questions
     */
    public function setCorrectAnswerKey($correctAnswerKey)
    {
        $this->correctAnswerKey = $correctAnswerKey;

        return $this;
    }

    /**
     * Get correctAnswerKey
     *
     * @return string
     */
    public function getCorrectAnswerKey()
    {
        return $this->correctAnswerKey;
    }

    /**
     * Set quizzes
     *
     * @param \User\Entity\Quizzes $quizzes
     *
     * @return Questions
     */
    public function setQuizzes(\User\Entity\Quizzes $quizzes = null)
    {
        $this->quizzes = $quizzes;

        return $this;
    }

    /**
     * Get quizzes
     *
     * @return \User\Entity\Quizzes
     */
    public function getQuizzes()
    {
        return $this->quizzes;
    }
}

