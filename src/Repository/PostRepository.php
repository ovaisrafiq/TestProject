<?php

namespace App\Repository;

use App\Entity\Post;
use App\Entity\Likes;
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

   
    public function getAllPosts($page_number = 1,$limit=null) {
        //$entityManager = $this->_em();
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT p.id as post_id,u.name as author,p.detail as description,p.imageUrl as image,u.email as author_email 
            FROM App\Entity\Post p Join 
            App\Entity\User u  group by p.id")->setMaxResults($page_number,$limit);
       //echo $query->getSQL();
        return $query->getArrayResult();        
    }

     public function getlikeCount($post_id) {
        //$entityManager = $this->_em();
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT count(l.id) as like_count FROM App\Entity\Likes l WHERE l.post = :post_id")            ->setParameter('post_id', $post_id);

        //echo $query->getSQL();
        return $query->getResult();        
    }
    
    public function getComments($post_id) {
        //$entityManager = $this->_em();
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT c.comment FROM App\Entity\Comments c WHERE c.post = :post_id")            ->setParameter('post_id', $post_id);

        //echo $query->getSQL();
        return $query->getResult();        
    }

// public function getAllPosts($limit = null)
// {
//     $qb = $this->createQueryBuilder('b')
//            ->select('b, c')
//            ->innerJoin('b.user', 'c')
//            ->addOrderBy('b.created_at', 'DESC');

//     if (false === is_null($limit))
//     $qb->setMaxResults($limit);
//     //echo $qb->getQuery()->getSQL();die;
//     return $qb->getQuery()->getResult();
// }
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
