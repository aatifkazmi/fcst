<?php
namespace User\Repository;

use Doctrine\ORM\EntityRepository;
use User\Entity\Videos;
use Doctrine\ORM\Query\Expr\Join;

/**
 * This is the custom repository class for Courses entity.
 */
class CoursesRepository extends EntityRepository
{
    public function fetchModulesAndVideos($courseId, $userId)
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('v')
            ->from(Videos::class, 'v')
            ->innerJoin('v.modules', 'm', Join::WITH, 'v.modules = m.id')
            ->innerJoin('m.courses', 'c', Join::WITH, 'm.courses = c.id')
            ->innerJoin('c.users', 'uhc', Join::WITH, 'uhc.id = :user_id')
            ->where('c.id = :course_id');
        
        $queryBuilder->setParameters(array(
            'course_id' => $courseId,
            'user_id' => $userId
        ));
        return $queryBuilder->getQuery();
    }

}