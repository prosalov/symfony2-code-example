<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\TimeGroup;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\UnexpectedResultException;

class TimeGroupRepository extends EntityRepository
{
    /**
     * Get First Available Time Group
     *
     * @param $event
     * @return TimeGroup
     */
    public function getAvailableTimeGroup($event)
    {
        try {
            $this->createQueryBuilder('tG')
                ->andWhere('tG.registrationEvent = :event')
                ->setParameter('event', $event)
                ->andWhere('tG.amount < tG.capacity')
                ->setMaxResults(1)
                ->orderBy('tG.time', 'ASC')
                ->getQuery()
                ->getSingleResult()
            ;
        } catch (UnexpectedResultException $e) {
            return null;
        }
    }
}
