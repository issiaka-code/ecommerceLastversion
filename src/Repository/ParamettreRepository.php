<?php

namespace App\Repository;

use App\Entity\Paramettre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Paramettre>
 *
 * @method Paramettre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Paramettre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Paramettre[]    findAll()
 * @method Paramettre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParamettreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Paramettre::class);
    }

//    /**
//     * @return Paramettre[] Returns an array of Paramettre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Paramettre
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
