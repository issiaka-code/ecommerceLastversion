<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ParamettreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils,ParamettreRepository $paramettreRepository,Request $request,CategorieRepository $categorieRepository): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        $form = $this->createFormBuilder()
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $recherche = $request->request->get('recherche');
            return  $this->redirectToRoute('app_recherche',['valeur' => $recherche]);
        }

        if (isset($_POST['btn-search-moibil']))
        {
            $recherche = $request->get('rechercheMobile');
            return  $this->redirectToRoute('app_recherche',['valeur' => $recherche]);
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig',
            ['last_username' => $lastUsername,
                'error' => $error,
                'paramettre'=> $paramettreRepository->findAll(),
                'form' => $form->createView(),
                'categories'=> $categorieRepository->findAll()
            ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
