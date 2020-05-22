<?php

namespace App\Repository;

use App\Entity\LoanRepayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LoanRepayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method LoanRepayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method LoanRepayment[]    findAll()
 * @method LoanRepayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoanRepaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoanRepayment::class);
    }

    // /**
    //  * @return LoanRepayment[] Returns an array of LoanRepayment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LoanRepayment
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
