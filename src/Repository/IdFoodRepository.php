<?php

namespace App\Repository;

use App\Entity\IdFood;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IdFood|null find($id, $lockMode = null, $lockVersion = null)
 * @method IdFood|null findOneBy(array $criteria, array $orderBy = null)
 * @method IdFood[]    findAll()
 * @method IdFood[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdFoodRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IdFood::class);
    }

//    /**
//     * @return IdFood[] Returns an array of IdFood objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IdFood
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
