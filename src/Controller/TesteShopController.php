<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TesteShopController extends AbstractController
{
    #[Route('/teste/shop', name: 'app_teste_shop')]
    public function index(): Response
    {
        return $this->render('teste_shop/index.html.twig', [
            'controller_name' => 'TesteShopController',
        ]);
    }
}
