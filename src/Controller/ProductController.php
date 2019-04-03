<?php


namespace App\Controller;


class ProductController
{


    public function product($name = 'matthieu')
    {
        dump($name);

        return $this->render('product/list.product.twig', [
            'name' =>ucfirst($name),
            'product' =>['Nom', 'Slug', 'Description']
        ]);
}
}