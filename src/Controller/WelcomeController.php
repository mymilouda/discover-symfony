<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WelcomeController extends AbstraController
{
    /**
     *  @Route("/hello", name="hello")
     */
    public function hello()
    {
        $name = 'Matthieu';

        dump($name);

        return $this->render('welcome/hello.html.twig', [
            'name' => $name
        ]);

        return new Response('
        <html><body> '.$name.'</body></html>'
        );
    }
}