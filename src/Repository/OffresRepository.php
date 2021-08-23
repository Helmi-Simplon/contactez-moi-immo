<?php

namespace App\Repository;

use App\Entity\Offres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Offres|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offres|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offres[]    findAll()
 * @method Offres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offres::class);
    }

    // /**
    //  * @return Offres[] Returns an array of Offres objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Offres
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllWithAdressesAndImages()
    {
        return $this->createQueryBuilder('o')
            ->addselect('a','u','i')
            ->leftjoin('o.adresse','a')
            ->leftjoin('o.vendeur','u')
            ->leftjoin('o.image','i')
            ->andWhere('o.actif = :actif')
            ->setParameter('actif', true)
            ->orderBy('o.date_offre', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function countOffres()
    {
        return $this->createQueryBuilder('o')
            ->select('count(o.id) as total')
            ->getQuery()
            ->getScalarResult();
    }
}
