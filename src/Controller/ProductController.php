<?php

/*
 * This file is part of the discover-symfony package.
 *
 * (c) Matthieu Mota <matthieu@boxydev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $products = [];

    public function __construct()
    {
        $this->products = [
            ['name' => 'iPhone X', 'slug' => 'iphone-x', 'description' => 'Un iPhone de 2017', 'price' => 999],
            ['name' => 'iPhone XR', 'slug' => 'iphone-xr', 'description' => 'Un iPhone de 2018', 'price' => 1099],
            ['name' => 'iPhone XS', 'slug' => 'iphone-xs', 'description' => 'Un iPhone de 2018', 'price' => 1199]
        ];
    }

    /**
     * @Route("/product/random")
     */
    public function random()
    {
        // On cherche un produit aléatoirement dans le tableau
        $product = $this->products[array_rand($this->products)];

        return $this->render('product/random.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * @Route("/product/{page}", requirements={"page":"\d+"})
     */
    public function list($page = 1)
    {
        $begin = $page > 1 ? ($page - 1) * 2 : 0;
        $products = array_slice($this->products, $begin, 2);
        $maxPages = ceil(count($this->products) / 2);

        // $products = array_slice($this->products, ($page - 1) * 2, 2);

        if (empty($products)) {
            throw $this->createNotFoundException();
        }

        return $this->render('product/list.html.twig', [
            'products' => $products,
            'maxPages' => $maxPages,
            'currentPage' => $page
        ]);
    }

    /**
     * @Route("/product/create")
     */
    public function create(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());
            dump($product);
            dump($product === $form->getData());
        }

        return $this->render('product/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/product/order/{slug}")
     */
    public function order($slug)
    {
        $product = array_values(array_filter($this->products, function ($product) use ($slug) {
            return $product['slug'] === $slug;
        }));
        $product = $product[0] ?? null;

        if ($product) {
            $this->addFlash('success', 'Nous avons bien pris en compte votre commande '.$product['name'].' de '.$product['price'].' €');
        }

        return $this->redirectToRoute('app_product_list');
    }

    /**
     * @Route("/product/{slug}")
     */
    public function show($slug)
    {
        foreach ($this->products as $product) {
            if ($product['slug'] === $slug) {
                return $this->render('product/show.html.twig', [
                    'product' => $product
                ]);
            }
        }

        // dump($this->products[array_search($slug, array_column($this->products, 'slug'))]);
        // On affiche une 404
        throw $this->createNotFoundException('Le produit n\'existe pas');
    }

    /**
     * @Route("/product.json")
     */
    public function api(Request $request)
    {
        // Si la requête n'est pas en AJAX, on renvoie une 404.
        if (!$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException();
        }

        return $this->json($this->products);
    }
}
