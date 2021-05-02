<?php
namespace User\Repository;

use Doctrine\ORM\EntityRepository;
use User\Entity\Users;

/**
 * This is the custom repository class for User entity.
 */
class UsersRepository extends EntityRepository
{
    /**
     * Retrieves all users in descending dateCreated order.
     * @return Query
     */
    public function findAllUsers()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('u')
            ->from(Users::class, 'u')
            ->orderBy('u.dateCreated', 'DESC');
        
        return $queryBuilder->getQuery();
    }
}