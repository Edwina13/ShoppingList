<?php

namespace App\Repository;

use App\Entity\ShoppingListProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShoppingListProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoppingListProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoppingListProduct[]    findAll()
 * @method ShoppingListProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingListProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingListProduct::class);
    }

    // /**
    //  * @return ShoppingListProduct[] Returns an array of ShoppingListProduct objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ShoppingListProduct
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
      * @return ShoppingListProduct[] Returns an array of ShoppingListProduct objects
     */
    public function findByShoppingList($id)
    {
        return $this->createQueryBuilder('slp')
            ->andWhere('slp.shopping_list= :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
}
