<?php

namespace App\Repository;

use App\Entity\Demandes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Demandes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Demandes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Demandes[]    findAll()
 * @method Demandes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Demandes::class);
    }

    /**
     * @return Demandes[] Returns an array of Demandes objects
     */

    public function findAllWithAdresses()
    {
        return $this->createQueryBuilder('d')
            ->addselect('a','u','i')
            ->leftjoin('d.adresses','a')
            ->leftjoin('d.acheteur','u')
            ->leftjoin('u.image','i')
            ->andWhere('d.actif = :actif')
            ->setParameter('actif', true)
            ->orderBy('d.date_demande', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function countDemandes()
    {
        return $this->createQueryBuilder('d')
            ->select('count(d.id) as total')
            ->getQuery()
            ->getScalarResult();
    }

    

    /*
    public function findOneBySomeField($value): ?Demandes
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
