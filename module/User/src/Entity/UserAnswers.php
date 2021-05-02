<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserAnswers
 *
 * @ORM\Table(name="user_answers", indexes={@ORM\Index(name="fk_users_has_questions_questions1_idx", columns={"questions_id"}), @ORM\Index(name="fk_users_has_questions_users_idx", columns={"users_id"}), @ORM\Index(name="fk_users_has_questions_quizes_idx", columns={"quiz_id"})})
 * @ORM\Entity
 */
class UserAnswers
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
     * @ORM\Column(name="user_answer_key", type="string", length=45, precision=0, scale=0, nullable=false, unique=false)
     */
    private $userAnswerKey;

    /**
     * @var \User\Entity\Questions
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\Questions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="questions_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $questions;

    /**
     * @var \User\Entity\Quizzes
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\Quizzes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="quiz_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $quiz;

    /**
     * @var \User\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $users;


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
     * Set userAnswerKey
     *
     * @param string $userAnswerKey
     *
     * @return UserAnswers
     */
    public function setUserAnswerKey($userAnswerKey)
    {
        $this->userAnswerKey = $userAnswerKey;

        return $this;
    }

    /**
     * Get userAnswerKey
     *
     * @return string
     */
    public function getUserAnswerKey()
    {
        return $this->userAnswerKey;
    }

    /**
     * Set questions
     *
     * @param \User\Entity\Questions $questions
     *
     * @return UserAnswers
     */
    public function setQuestions(\User\Entity\Questions $questions = null)
    {
        $this->questions = $questions;

        return $this;
    }

    /**
     * Get questions
     *
     * @return \User\Entity\Questions
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Set quiz
     *
     * @param \User\Entity\Quizzes $quiz
     *
     * @return UserAnswers
     */
    public function setQuiz(\User\Entity\Quizzes $quiz = null)
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * Get quiz
     *
     * @return \User\Entity\Quizzes
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * Set users
     *
     * @param \User\Entity\Users $users
     *
     * @return UserAnswers
     */
    public function setUsers(\User\Entity\Users $users = null)
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
}

