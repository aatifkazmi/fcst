<?php
namespace User\Controller;

use DoctrineORMModule\Proxy\__CG__\User\Entity\Courses;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Entity\Quizzes;
use User\Entity\Questions;
use User\Entity\UserAnswers;
use User\Entity\Users;
use User\Entity\UsersHasCourses;

/**
 * This controller is responsible for user management (adding, editing, 
 * viewing users and changing user's password).
 */
class QuizController extends AbstractActionController 
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Constructor. 
     */
    public function __construct($entityManager,$authService)
    {
        $this->entityManager = $entityManager;
        $this->authService = $authService;
    }

    public function indexAction() 
    {
        $id = $this->params()->fromRoute('id', 0);
        $quiz = $this->entityManager->getRepository(Quizzes::class)
                ->findOneBy(['courses' => $id]);

        if(!$quiz) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $userAnswers = $this->entityManager->getRepository(UserAnswers::class)
            ->findOneBy(['quiz' => $quiz->getId()]);

        if($userAnswers && $userAnswers->getId()){
         
            return $this->redirect()->toRoute('quiz', 
                ['action'=>'result', 'id'=>$quiz->getId()]);
        }

        return new ViewModel([
            'quiz' => $quiz
        ]);
    }
    
    public function questionAction() 
    {
        $id = $this->params()->fromRoute('id', 0);

        if ($id<1) {
             $this->getResponse()->setStatusCode(404);
            return;
        }
        $quiz = $this->entityManager->getRepository(Quizzes::class)
                ->findOneBy(['courses' => $id]);

        $userAnswers = $this->entityManager->getRepository(UserAnswers::class)
            ->findOneBy(['quiz' => $quiz->getId()]);

        if($userAnswers && $userAnswers->getId()){
         
            echo 'Quiz already attempted';exit;
        }

        $questions = $this->entityManager->getRepository(Questions::class)
            ->findBy(['quizzes' => $quiz->getId()]);

        if ($this->getRequest()->isPost()) {

            $answers = $this->params()->fromPost('answer');   
            
            foreach($answers as $questionId=>$answer) {
                
                $user = $this->entityManager->getRepository(Users::class)
                    ->findOneByEmail($this->authService->getIdentity());
                $question = $this->entityManager->getRepository(Questions::class)
                    ->find($questionId); 
                
                $userAnswer = new UserAnswers();
                $userAnswer->setUsers($user);
                $userAnswer->setQuestions($question);
                $userAnswer->setUserAnswerKey($answer);
                $userAnswer->setQuiz($quiz);
                // Add the entity to the entity manager.
                $this->entityManager->persist( $userAnswer);
                
                // Apply changes to database.
                $this->entityManager->flush();
            }
            // Redirect to "view" page
            return $this->redirect()->toRoute('quiz', 
                ['action'=>'result', 'id'=>$quiz->getId()]);     
        }

        return new ViewModel([
            'quiz' => $quiz,
            'questions' => $questions,
        ]);
    }

    public function resultAction() {

        $id = $this->params()->fromRoute('id', 0);
        $courseId = $this->entityManager->getRepository(Quizzes::class)
                ->findOneBy(['courses' => $id]);

        $user = $this->entityManager->getRepository(Users::class)
                ->findOneByEmail($this->authService->getIdentity());

        $courseId = $this->params()->fromRoute('id', 0);

        $userId = $user->getId();

        $userAnswers = $this->entityManager->getRepository(Quizzes::class)
                ->fetchUserAnswers($courseId, $userId)->getResult();

        $quizQuestions = $this->entityManager->getRepository(Quizzes::class)
                ->fetchQuestions($courseId)->getResult();
        
        $totalQuestions = sizeof($quizQuestions);

        $correctAnswerCount = 0;
       
        if($userAnswers) {
            
            foreach($userAnswers as $answer) {
               
                $question = $this->entityManager->getRepository(Questions::class)
                    ->find($answer->getQuestions());
                
                if($question->getCorrectAnswerKey() == $answer->getUserAnswerKey()){
                    $correctAnswerCount++;
                }
            }
        }

        $percentage = $correctAnswerCount/$totalQuestions*100;

        if($percentage >= 50) {
            
            $qb = $this->entityManager->createQueryBuilder();
            $q = $qb->update(UsersHasCourses::class, 'uhc')
                ->set('uhc.score', '?1')
                ->set('uhc.qualified_date', '?4')
                ->where('uhc.users = ?2 AND uhc.courses = ?3')
                ->setParameter(1, $percentage)
                ->setParameter(2, $user->getId())
                ->setParameter(3, $courseId)
                ->setParameter(4, date('Y-m-d'))
                ->getQuery();
            $q->execute();
        }

        return new ViewModel([
            'percentage' => $percentage,
            'course_id' => $courseId
        ]);
    }
}