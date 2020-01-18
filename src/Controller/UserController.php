<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserController
{

	private $userRepository;

    private $jwtManager;

    private $jwtEncoder;


    public function __construct(UserRepository $userRepository,JWTTokenManagerInterface $jwtManager,JWTEncoderInterface $jwtEncoder)
    {
        $this->userRepository = $userRepository;
        $this->jwtManager = $jwtManager;
        $this->jwtEncoder = $jwtEncoder;
        //$this->jwtManager = $jwtManager;
    }

    public function number(Request $request,UserProviderInterface $userProvider)
    {
        //echo phpinfo();
    	//echo "teest";die;
        //echo $this->token = $tokenStorage->getToken();
        //$this->user = $this->token->getUser();
        //$user = $this->get('security.token_storage')->getToken()->getUser();  
        //print_r($user);die;
        //$request->headers->get('Authorization');
        try{  
        $data = $this->jwtEncoder->decode($this->tokenStorageInterface->getToken());
        echo $data;
        }catch (\Exception $e) {
        throw new \Symfony\Component\Security\Core\Exception\BadCredentialsException($e->getMessage(), 0, $e);
        }
        die;
        if(!$data){
          return null;
        }
        $user = $jwtEncoder->decode($request->headers->get('Authorization'));
        print_r($user);die;


        $authorizationHeader = $request->headers->get('Authorization');
        $response['user'] = $this->jwtManager->decode($authorizationHeader);
        print_r($response['user']);
        die;
        //echo $this->user;die;
        //$authorizationHeader = $request->headers->get('Authorization');
        //return substr($authorizationHeader, 7);

        //$number = random_int(0, 100);
        $jwtManager = $this->get('lexik_jwt_authentication.jwt_manager');
        $token = $jwtManager->create($user);
        return new Response(
            '<html><body>'.substr($authorizationHeader, 7).'</body></html>'
        );
    }

    // public function register2(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    // {
    // 	// $user = new User();
    //  //    $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
    //  //    $user->setName($request->email);
    //  //    $user->setPassword($password);
    //  //    $user->setName($request->name);


    //  //    // 4) save the User!
    //  //    $entityManager = $this->getDoctrine()->getManager();
    //  //    $entityManager->persist($user);
    //  //    $entityManager->flush();
    //  //    return new Response($json_data);
    // }

    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $data = json_decode($request->getContent(), true);

        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];
         //$customer = $this->userRepository->findOneBy(['id' => $id]);
        //print_r($data);
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        if (empty($name) || empty($email) || empty($password)) {
			
            //$response = JsonResponse::fromJsonString('{ "data": }');
           return new JsonResponse(['status' => '{Expecting mandatory parameters!}'], Response::HTTP_CREATED);
            //return new Response('Expecting mandatory parameters!');
            //throw new NotFoundHttpException('Expecting mandatory parameters!');
        }
        $user = new User();
        $password = $passwordEncoder->encodePassword($user, $password);
        $this->userRepository->saveUser($name,$email,$password);
         return new Response('{ status: User Register Successfully! }');
        //return new JsonResponse(['status' => 'Customer created!'], Response::HTTP_CREATED);
    }

    public function login(){

    }
}