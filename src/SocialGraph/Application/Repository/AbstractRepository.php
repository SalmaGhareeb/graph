<?php

namespace SocialGraph\Application\Repository;

use Doctrine\ORM\EntityRepository;
use SocialGraph\Port\Interfaces\ModelInterface;
use SocialGraph\Port\Interfaces\RepositoryInterface;

/**
 * Class AbstractRepository
 *
 * @package SocialGraph\Application\Repository
 */
abstract class AbstractRepository extends EntityRepository implements RepositoryInterface
{
    /**
     * @param \SocialGraph\Port\Interfaces\ModelInterface $model
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(ModelInterface $model): void
    {
        $em = $this->getEntityManager();
        $em->persist($model);
        $em->flush($model);
    }

    /**
     * @param \SocialGraph\Port\Interfaces\ModelInterface $graph
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function delete(ModelInterface $graph): void
    {
        $em = $this->getEntityManager();
        $em->remove($graph);
        $em->flush($graph);
    }
}
