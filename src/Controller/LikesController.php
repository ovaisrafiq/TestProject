<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Likes;
use App\Repository\LikesRepository;
use App\Repository\PostRepository;
use Symfony\Component\Security\Core\Security;


class LikesController
{

	private $likesRepository;

    public function __construct(LikesRepository $likesRepository,PostRepository $postRepository,Security $security)
    {
        $this->likesRepository = $likesRepository;
        $this->postRepository = $postRepository;
        $this->security = $security;
    }

    public function create(Request $request)
    {

        $data = json_decode($request->getContent(), true);
        $user = $this->security->getUser();
        
        $post_id = $data['post_id'];
         //$customer = $this->userRepository->findOneBy(['id' => $id]);
        //print_r($data);
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        if (empty($post_id) ) {
			
            //$response = JsonResponse::fromJsonString('{ "data": }');
           return new JsonResponse(['status' => '{Expecting mandatory parameters!}'], Response::HTTP_CREATED);
            //return new Response('Expecting mandatory parameters!');
            //throw new NotFoundHttpException('Expecting mandatory parameters!');
        }
        $post = $this->postRepository->findOneByPost($post_id);
        if (!$post) {
           return new JsonResponse(['status' => '{The post not exist!}'], Response::HTTP_CREATED);
        }

        //$check_like = $this->likesRepository->findOneByLike($user->getId(),$post_id);
        //print_r($check_like);
        //echo "===";die;
        //if ($check_like) {
          // return new JsonResponse(['status' => '{The like already exist!}'], Response::HTTP_CREATED);
        //}
        //check like if exist then dont create

        $likes = new Likes();
        $this->likesRepository->saveLike($post,$user);
         return new Response('{ status: Post Liked by user Successfully! }');
        //return new JsonResponse(['status' => 'Customer created!'], Response::HTTP_CREATED);
    }

    public function login(){

    }
}