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


    public function register()
    {
    	$client = static::createClient();

        $client->request('GET', '/post/hello-world');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}