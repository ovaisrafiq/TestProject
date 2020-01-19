<?php

namespace App\Repository;

use App\Entity\Likes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Likes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Likes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Likes[]    findAll()
 * @method Likes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Likes::class);
    }

    public function saveLike($post_id,$user_id)
    {
        $newLike = new Likes();
        $newLike
            ->setPost($post_id)
            ->setUser($user_id)
            ->setCreatedAt(new \DateTime('now'));
            $this->_em->persist($newLike);
            $this->_em->flush();
    }

    public function findOneByLike($user_id,$post_id)
    {
        //echo $user_id;die;
        // return $this->createQueryBuilder('p')
        //     ->andWhere('p.id = :user_id')
        //     ->andWhere('p.id = :post_id')
        //     ->setParameter('user_id', $user_id)
        //     ->setParameter('post_id', $post_id)
        //     ->getQuery()
        //     ->getResult();

       $query = $this->getEntityManager()->createQuery('SELECT l.id FROM likes l WHERE (l.post_id = :post_id AND l.user_id = :user_id)');
        $query->setParameters(array(
        'user_id' => $user_id,
        'post_id' => $post_id
        ));
        $users = $query->getResult();        
        print_r($users);die;
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
