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


class LoginControllerTest extends WebTestCase
{


    public function testlogin()
    {
        $client = static::createClient();

        //$client->request('GET', '/post/list');
        $client->request(
		    'GET',
		    '/api/login_check',
		    [],
		    [],
		    ['CONTENT_TYPE' => 'application/json'],
			'{"email":"ovaisrafiq@gmail.com","password":"Test123"}'		    
			);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());//$this->assertContains('Hello World', $crawler->filter('h1')->text());
    }

    public function testRegister()
    {
        $client = static::createClient();

        //$client->request('GET', '/post/list');
        $client->request(
		    'POST',
		    '/register',
		    [],
		    [],
		    ['CONTENT_TYPE' => 'application/json'],
			'{"name":"ovais","email":"ovaisrafiq802@gmail.com","password":"Test123"}'		    
			);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());//$this->assertContains('Hello World', $crawler->filter('h1')->text());
    }

}