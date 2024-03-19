<?php

namespace App\Controller;

use App\Repository\ParamettreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Banque;
use App\Entity\Crypto;
use App\Entity\Facturation;
use App\Repository\BanqueRepository;
use App\Repository\CategorieRepository;
use App\Repository\CryptoRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;


class PaiementController extends AbstractController
{
    private  ProduitRepository $produitRepository;
    private  CategorieRepository $categorieRepository;
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;
    private BanqueRepository $banqueRepository;
    private CryptoRepository $cryptoRepository;
    Private ParamettreRepository $paramettreRepository;
    public  function __construct(ParamettreRepository $paramettreRepository,CryptoRepository $cryptoRepository,BanqueRepository $banqueRepository,UserRepository $userRepository,EntityManagerInterface $entityManager,CategorieRepository $categorieRepository,ProduitRepository $produitRepository )
    {
        $this->produitRepository = $produitRepository;
        $this->categorieRepository = $categorieRepository;
        $this->entityManager= $entityManager;
        $this->userRepository= $userRepository;
        $this->banqueRepository= $banqueRepository;
        $this->cryptoRepository = $cryptoRepository;
        $this->paramettreRepository = $paramettreRepository;
    }
    #[Route('/payer/rib/{id}', name: 'app_payer_rib')]
    public function payerRib(Facturation $facturation,Request $request): Response
    {

        $resul=$this->banqueRepository->findAll();
        $listeCategorie=$this->categorieRepository->findAll();
        $form = $this->createFormBuilder()
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $recherche = $request->request->get('recherche');
            return  $this->redirectToRoute('app_recherche',['valeur' => $recherche]);
        }

        $formMobile = $this->createFormBuilder()
            ->getForm();

        $formMobile->handleRequest($request);

        if ($formMobile->isSubmitted()) {
            $recherche = $request->request->get('rechercheMobile');
            return  $this->redirectToRoute('app_recherche',['valeur' => $recherche]);
        }

        return $this->render('paiement/rib.html.twig', [
            'rib' => $resul,
            'montantTotal' => $facturation->getPrixTotale(),
            'liste_categorie'=>$listeCategorie,
            'paramettre'=> $this->paramettreRepository->findAll(),
            'form' => $form->createView(),
            'categories'=> $listeCategorie,
        ]);
    }

    #[Route('/crypto/{id}', name: 'app_crypto')]
    public function crypto(Facturation $facturation,Request $request ): Response
    {

        $crypto=$this->cryptoRepository->findAll();
        $listeCategorie=$this->categorieRepository->findAll();
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

        return $this->render('paiement/crypto.html.twig', [
            'crypto' =>$crypto,
            'montantTotal' => $facturation->getPrixTotale(),
            'liste_categorie'=>$listeCategorie,
            'paramettre'=> $this->paramettreRepository->findAll(),
            'form' => $form->createView(),
            'categories'=> $listeCategorie,

        ]);
    }

}
