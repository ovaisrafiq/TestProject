<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function savePost($detail,$imageUrl,$user_id)
    {
        $newPost = new Post();
        $newPost
            ->setDetail($detail)
            ->setImageUrl($imageUrl)
            ->setUser($user_id)
            ->setCreatedAt(new \DateTime('now'));
            $this->_em->persist($newPost);
            $this->_em->flush();
    }

    public function findOneByPost($id): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

   
public function getAllPosts($limit = null)
{
    $qb = $this->createQueryBuilder('b')
           ->select('b, c')
           ->innerJoin('b.user', 'c')
           ->addOrderBy('b.created_at', 'DESC');

    if (false === is_null($limit))
    $qb->setMaxResults($limit);
    //echo $qb->getQuery()->getSQL();die;
    return $qb->getQuery()->getResult();
}
    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
