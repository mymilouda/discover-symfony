<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class WelcomeController
{
    /**
     *  @Route("/hello", name="hello")
     */
    public function hello()
    {
        return new Response('
        <html><body>Hello Matthieu</body></html>');
    }
}