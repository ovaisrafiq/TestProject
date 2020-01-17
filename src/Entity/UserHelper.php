<?php

namespace App\Entity\User;

class WebServiceHelper
{

    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

        #------------------------ User -----------------------
    public function registration($request_array)
    {
      $user = $this->container->get('user.helper.user')->findByEmail($request_array['email']);       
    }

}