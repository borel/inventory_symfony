<?php
/**
 * Created by PhpStorm.
 * User: pbborel
 * Date: 17/11/2014
 * Time: 16:46
 */

namespace CZS\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class LoanRepository extends EntityRepository
{

    public function myFindByEquipmentAndEndDate($idEquipment)
    {
        $queryBuilder = $this->createQueryBuilder('loan');
        $queryBuilder
            ->where($queryBuilder->expr()->isNull('loan.dateEnd'));
        $queryBuilder
            ->join('loan.equipment','equipment')
            ->addSelect('equipment')
            ->andWhere(('equipment.id = :id'))
            ->setParameter('id',$idEquipment);
        return $queryBuilder
            ->getQuery()
            ->getResult()
            ;
    }



}