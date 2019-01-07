<?php

namespace App\Repository;

use App\Entity\DietItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DietItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method DietItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method DietItem[]    findAll()
 * @method DietItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DietItemRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DietItem::class);
    }

//    /**
//     * @return DietItem[] Returns an array of DietItem objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DietItem
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
