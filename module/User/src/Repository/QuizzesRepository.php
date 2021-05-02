<?php
namespace User\Repository;

use Doctrine\ORM\EntityRepository;
use User\Entity\UserAnswers;
use User\Entity\Questions;
use Doctrine\ORM\Query\Expr\Join;

/**
 * This is the custom repository class for Courses entity.
 */
class QuizzesRepository extends EntityRepository
{
    public function fetchUserAnswers($courseId, $userId)
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('ua')
            ->from(UserAnswers::class, 'ua')
            ->innerJoin('ua.quiz', 'q', Join::WITH, 'ua.quiz = q.id')
            ->where('q.courses = :course_id')
            ->andWhere('ua.users = :user_id');
        
        $queryBuilder->setParameters(array(
            'course_id' => $courseId,
            'user_id' => $userId
        ));
        return $queryBuilder->getQuery();
    }
    
    public function fetchQuestions($courseId)
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('q')
            ->from(Questions::class, 'q')
            ->innerJoin('q.quizzes', 'qz', Join::WITH, 'q.quizzes = qz.id')
            ->where('qz.courses = :course_id');
        
        $queryBuilder->setParameters(array(
            'course_id' => $courseId
        ));

        return $queryBuilder->getQuery();
    }

}