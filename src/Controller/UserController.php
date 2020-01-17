<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Repository\UserRepository;

class UserController
{

	private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function number()
    {
    	echo "teest";die;
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
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
         $customer = $this->userRepository->findOneBy(['id' => $id]);
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

    public function getUser(){

    }
}