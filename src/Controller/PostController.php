<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;


class PostController
{

	private $postRepository;

    public function __construct(PostRepository $postRepository,Security $security,EntityManagerInterface $entityManager)
    {
        $this->postRepository = $postRepository;
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function create(Request $request)
    {

        $data = json_decode($request->getContent(), true);
        $user = $this->security->getUser();
        
        $detail = $data['detail'];
        $image_url = $data['image_url'];
         //$customer = $this->userRepository->findOneBy(['id' => $id]);
        //print_r($data);
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        if (empty($detail) ) {
			
            //$response = JsonResponse::fromJsonString('{ "data": }');
           return new JsonResponse(['status' => '{Expecting mandatory parameters!}'], Response::HTTP_CREATED);
            //return new Response('Expecting mandatory parameters!');
            //throw new NotFoundHttpException('Expecting mandatory parameters!');
        }
        $post = new Post();
        $this->postRepository->savePost($detail,$image_url,$user);
         return new Response('{ status: Post Created Successfully! }');
        //return new JsonResponse(['status' => 'Customer created!'], Response::HTTP_CREATED);
    }

    public function update(Request $request, PostRepository $postRepository,$id){
		
		$data = json_decode($request->getContent(), true);
        $user = $this->security->getUser();
        
        $detail = $data['detail'];
        $image_url = isset($data['image_url']) ? $data['image_url']:'';
        
		$post = $postRepository->find($id);
        $date1 = $post->getCreatedAt();
        $date2 = $date1->diff(new \DateTime());
        $date3 = new \DateTime();
        
	    if (!$post){
		    return new JsonResponse(['status' => '{{Post not Found!}'], Response::HTTP_CREATED);
	    }
        if($date2->h >1){
            return new JsonResponse(['status' => '{{You can not edit this post as its past 1 hour!}'], Response::HTTP_CREATED);   
        }
		$response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        //if (empty($detail) ) {
	
	    if (empty($detail)){
		    return new JsonResponse(['status' => '{{Parameters not found!}'], Response::HTTP_CREATED);
	    }

	    $post->setDetail($detail);
	    if(!empty($image_url)){
				    $post->setimageUrl($image_url);	    	
		}
		$this->entityManager->flush();
		return new JsonResponse(['status' => '{{Post updated Successfully!}'], Response::HTTP_CREATED);
	}

	public function delete(Request $request, PostRepository $postRepository,$id){
		
		$data = json_decode($request->getContent(), true);
        $user = $this->security->getUser();
         
		$post = $postRepository->find($id);
        $date1 = $post->getCreatedAt();
        $date2 = $date1->diff(new \DateTime());
        $date3 = new \DateTime();
        
	    if (!$post){
		    return new JsonResponse(['status' => '{{Post not Found!}'], Response::HTTP_CREATED);
	    }
        if($date2->h >1){
            return new JsonResponse(['status' => '{{You can not edit this post as its past 1 hour!}'], Response::HTTP_CREATED);   
        }
		$response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        //if (empty($detail) ) {
		$this->entityManager->remove($post);
		$this->entityManager->flush();
		return new JsonResponse(['status' => '{{Post deleted Successfully!}'], Response::HTTP_CREATED);
	}

     public function list(Request $request, PostRepository $postRepository){
        //$limit = 10;
        //$offset = 0;
        $data = json_decode($request->getContent(), true);

        $offset = $data['offset'];
        $limit = $data['limit'];
        $posts = $postRepository->getAllPosts($limit,$offset);

        $i=0;
        foreach($posts as  $val){
           $count  = $postRepository->getLikeCount($val["post_id"]);
           $getcomments  = $postRepository->getComments($val["post_id"]);
           //print_r($getcomments);die;
           //$array_count[] = $count[0]["like_count"];
            if ($count) { 
                $posts[$i]['likes'] = $count[0]["like_count"]; 
                } else { 
                $posts[$i]['likes'] = $count[0]["like_count"]; 
            } 
            if ($getcomments) { 
                $posts[$i]['comments'] = $getcomments; 
                } else { 
                $posts[$i]['comments'] = $getcomments; 
            } 
             $i++;
            
        }
 
  


        
         $postsListConf= array(
                'data' => $posts,
                'offset' => $offset,
                'limit' => $limit,
                'message' => 'Post list',
                'success' => 'true',
            );
       
   
        $data['posts'] = $postsListConf;
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
         return new JsonResponse($data["posts"]);


    }
    public function login(){

    }
}