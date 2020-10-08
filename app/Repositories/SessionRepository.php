<?php
namespace App\Repositories;

use Doctrine\ORM\EntityRepository;

class SessionRepository extends EntityRepository
{
    public function getOneByDate(\Datetime $date)
    {
        $dateString = toDateTimeString($date);

        $qb = $this->createQueryBuilder('s');
        $qb
            ->where('s.start_datetime < :date')
            ->andWhere('s.end_datetime >= :date')
            ->orderBy('s.start_datetime', 'desc')
            ->setParameter('date', $dateString)
        ;
        $result = $qb->getQuery()->getResult();

        if (is_array($result)) {
            return $result[0];
        }

        return null;
    }

    public function getUserIdBySessionToken($sessionToken)
    {
        $qb = $this->createQueryBuilder('s');
        $qb
            ->where('s.token = :token')
            ->setParameter('token', $sessionToken)
        ;
        $result = $qb->getQuery()->getResult();
        if (count($result) > 0) {
            $session = $result[0];
            return $session->getUserId();
        }

        return null;
    }
}