<?php
	
	namespace App\Controller;


	use App\Entity\User;
	use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
	use Symfony\Component\Security\Core\User\UserInterface;
	use App\Repository\UserRepository;
	use Symfony\Component\Security\Core\Security;

	class AuthController extends ApiController
	{

		public function __construct(UserRepository $userRepository,Security $security)
    	{
        $this->userRepository = $userRepository;
        //$this->jwtManager = $jwtManager;
        //$this->jwtEncoder = $jwtEncoder;
        $this->security = $security;
        //$this->jwtManager = $jwtManager;
    }


		public function register(Request $request, UserPasswordEncoderInterface $encoder)
		{
			$em = $this->getDoctrine()->getManager();
			$request = $this->transformJsonBody($request);
			$name = $request->get('name');
			$password = $request->get('password');
			$email = $request->get('email');

			if (empty($name) || empty($password) || empty($email)){
				return $this->respondValidationError("Invalid Email or Password");
			}

			$check_existing_user = $this->userRepository->emailExist($email);
		    if(count($check_existing_user) == 0){
			    $user = new User($name);
				$user->setPassword($encoder->encodePassword($user, $password));
				$user->setEmail($email);
				$user->setName($name);
				$em->persist($user);
				$em->flush();

				$success= array(
                'message' => 'User Registered successfully',
                'success' => 'true',
	            );

				$response = new JsonResponse();
				$response->headers->set('Content-Type', 'application/json');
         		return new JsonResponse($success);

				//return $this->respondWithSuccess(sprintf('User %s successfully created', $user->getUsername()));
		    }else{
		    	$success= array(
                'message' => 'User already exist with this email',
                'status' => '422',
	            );

		    	$response = new JsonResponse();
				$response->headers->set('Content-Type', 'application/json');
         		return new JsonResponse($success);

		    	//return $this->respondValidationError("Email already exist");
		    }

		}

		/**
		 * @param UserInterface $user
		 * @param JWTTokenManagerInterface $JWTManager
		 * @return JsonResponse
		 */
		public function getTokenUser(UserInterface $user, JWTTokenManagerInterface $JWTManager)
		{
			return new JsonResponse(['token' => $JWTManager->create($user)]);
		}

	}