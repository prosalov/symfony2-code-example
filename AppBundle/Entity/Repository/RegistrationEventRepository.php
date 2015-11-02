<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\RegistrationEvent;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\UnexpectedResultException;

class RegistrationEventRepository extends EntityRepository
{
    /**
     * Query Builder for grid
     *
     * @return QueryBuilder
     */
    public function getGridQuery()
    {
        return $this->createQueryBuilder('rE')
            ->addSelect('cT', 's', 'c')
            ->leftJoin('rE.city', 'cT')
            ->leftJoin('rE.state', 's')
            ->leftJoin('rE.country', 'c')
        ;
    }

    /**
     * Get Event By Domain
     *
     * @param $domain
     * @return RegistrationEvent
     */
    public function getEventByDomain($domain)
    {
        try {
            $this->createQueryBuilder('e')
                ->andWhere('e.isPublished = true')
                ->andWhere('e.domain = :domain')
                ->setParameter('domain', $domain)
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleResult()
            ;
        } catch (UnexpectedResultException $e) {
            return null;
        }
    }
}
