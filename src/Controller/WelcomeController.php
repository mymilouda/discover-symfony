<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function home(Request $request, LoggerInterface $logger)
    {
        dump($request);
        dump($logger);

        // Equivalent à $_GET['toto'] ou $_POST['toto']
        dump($request->query->get('toto', 10));

        // Est-ce que c'est une requête AJAX
        dump($request->isXmlHttpRequest());

        // Méthode de la requête
        dump($request->isMethod('POST'));

        // Ecrire un log
        $logger->info('L\'utilisateur a supprimé un produit', ['produit' => 2]);

        return $this->render('welcome/index.html.twig');
    }

    /**
     * @Route("/style.css")
     */
    public function style()
    {
        $color = ['blue', 'red', 'yellow'];

        // Et si on retournait du CSS plutôt que de l'HTML ?
        $response = new Response('body { background-color: '.$color[array_rand($color)].' }');

        // On peut utiliser Content-Type, content-type ou content_type
        $response->headers->set('Content-Type', 'text/css');

        return $response;
    }

    /**
     * @Route(
     *     "/hello/{name}",
     *     name="hello",
     *     requirements={"name":"[a-z]{3,8}"}
     * )
     */
    public function hello($name = 'matthieu')
    {
        dump($name);

        return $this->render('welcome/hello.html.twig', [
            'name' => ucfirst($name)
        ]);
    }
}
