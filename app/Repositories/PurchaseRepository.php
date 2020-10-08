<?php
namespace App\Repositories;

use Doctrine\ORM\EntityRepository;

class PurchaseRepository extends EntityRepository
{
    public function getPurchasesByUserId($userId)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where('p.user_id = :userId')
            ->setParameter('userId', $userId)
        ;
        return $qb->getQuery()->getResult();
    }

    public function getPurchaseByPurchaseToken($purchaseToken)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where('p.purchase_token = :token')
            ->setParameter('token', $purchaseToken)
        ;
        $result = $qb->getQuery()->getResult();
        if (count($result) > 0) {
            return $result[0];
        }

        return null;
    }
}