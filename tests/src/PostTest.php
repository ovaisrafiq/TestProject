<?php
// src/Controller/LuckyController.php
namespace App\Tests\Controller;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\JsonResponse;
// use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
// use App\Entity\User;
// use App\Repository\UserRepository;
// use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class PostControllerTest extends WebTestCase
{


    public function testPostList()
    {
        $client = static::createClient();

        //$client->request('GET', '/post/list');
        $client->request(
		    'GET',
		    '/post/list',
		    [],
		    [],
		    ['CONTENT_TYPE' => 'application/json'],
		    
			);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());//$this->assertContains('Hello World', $crawler->filter('h1')->text());
    }

   //  public function getToken()
   //  {
   //      $client = static::createClient();

   //      //$client->request('GET', '/post/list');
   //      $responseData = $client->request(
		 //    'GET',
		 //    '/api/login_check',
		 //    [],
		 //    [],
		 //    ['CONTENT_TYPE' => 'application/json'],
			// '{"email":"ovaisrafiq@gmail.com","password":"Test123"}'		    
			// );
   //      $response = json_decode($client->getResponse()->getContent(), true);
   //      return $response["token"];
   //      //print_r($client->getResponse()->getContent()->g);
   //      //$this->assertEquals(200, $client->getResponse()->getStatusCode());
   //      //$this->assertContains('Hello World', $crawler->filter('token')->text());
   //  }

    public function testCreate()
    {
        $client = static::createClient();

        $responseData = $client->request(
		    'GET',
		    '/api/login_check',
		    [],
		    [],
		    ['CONTENT_TYPE' => 'application/json'],
			'{"email":"ovaisrafiq@gmail.com","password":"Test123"}'		    
			);
        $response = json_decode($client->getResponse()->getContent(), true);
        
        //$client->request('GET', '/post/list');
        $token = $response["token"];
        $responseData = $client->request(
		    'POST',
		    '/post/create',
		    [],
		    [],
		    ['CONTENT_TYPE'=>'application/json','AUTHORIZATION' => 'Bearer '.$token],
			'{"detail":"hello test","image_url":"http://abc.com"}'		    
			);
        $response = json_decode($client->getResponse()->getContent(), true);
        //print_r($response);
        //return $response["token"];
        //print_r($client->getResponse()->getContent()->g);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //$this->assertContains('Hello World', $crawler->filter('token')->text());
    }

}