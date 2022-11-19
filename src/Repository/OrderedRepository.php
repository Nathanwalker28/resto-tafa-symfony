<?php

namespace App\Repository;

use App\Entity\Ordered;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ordered>
 *
 * @method Ordered|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ordered|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ordered[]    findAll()
 * @method Ordered[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ordered::class);
    }

    public function add(Ordered $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Ordered $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Ordered[] Returns an array of Ordered objects
     */
    public function findByquantity($value): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.quantity = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Ordered
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    
    /**
     * findMaxQuantity
     *
     * @return Ordered[]
     */
    public function findMaxQuantity(): array
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.quantity', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }
}
