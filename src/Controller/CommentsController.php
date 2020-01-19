<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Comments;
use App\Repository\CommentsRepository;
use App\Repository\PostRepository;
use Symfony\Component\Security\Core\Security;


class CommentsController
{

	private $commentsRepository;

    public function __construct(CommentsRepository $commentsRepository,PostRepository $postRepository,Security $security)
    {
        $this->commentsRepository = $commentsRepository;
        $this->postRepository = $postRepository;
        $this->security = $security;
    }

    public function create(Request $request)
    {

        $data = json_decode($request->getContent(), true);
        $user = $this->security->getUser();
        
        $post_id = $data['post_id'];
        $comment = $data['comment'];
         //$customer = $this->userRepository->findOneBy(['id' => $id]);
        //print_r($data);
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        if (empty($post_id) || empty($comment)  ) {
			
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

        $comments = new Comments();
        $this->commentsRepository->saveComment($post,$user,$comment);
         return new Response('{ status: Posted comment Successfully! }');
        //return new JsonResponse(['status' => 'Customer created!'], Response::HTTP_CREATED);
    }

    public function login(){

    }
}