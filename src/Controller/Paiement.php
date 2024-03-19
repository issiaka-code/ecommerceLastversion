<?php

namespace App\Controller;

use App\Entity\Banque;
use App\Entity\Crypto;
use App\Entity\Facturation;
use App\Repository\BanqueRepository;
use App\Repository\CategorieRepository;
use App\Repository\CryptoRepository;
use App\Repository\ProduitRepository;
//use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
class Paiement extends AbstractController
{
//    private  ProduitRepository $produitRepository;
    private  CategorieRepository $categorieRepository;
    private EntityManagerInterface $entityManager;
//    private UserRepository $userRepository;
    private BanqueRepository $banqueRepository;
    private CryptoRepository $cryptoRepository;
//    public  function __construct(CryptoRepository $cryptoRepository,BanqueRepository $banqueRepository,UserRepository $userRepository,EntityManagerInterface $entityManager,CategorieRepository $categorieRepository,ProduitRepository $produitRepository )
//    {
//        $this->produitRepository = $produitRepository;
//        $this->categorieRepository = $categorieRepository;
//        $this->entityManager= $entityManager;
//        $this->userRepository= $userRepository;
//        $this->banqueRepository= $banqueRepository;
//        $this->cryptoRepository = $cryptoRepository;
//    }
    #[Route('/payer/rib/{id}', name: 'app_payer_rib')]
    public function payerRib(Facturation $facturation): Response
    {

        $resul=$this->banqueRepository->findAll();
        $listeCategorie=$this->categorieRepository->findAll();

        return $this->render('paiement/rib.html.twig', [
            'rib' => $resul,
            'montantTotal' => $facturation->getPrixTotale(),
            'liste_categorie'=>$listeCategorie,
            'categories'=> $listeCategorie,
        ]);
    }

    #[Route('/crypto/{id}', name: 'app_crypto')]
    public function crypto(Facturation $facturation ): Response
    {

        $crypto=$this->cryptoRepository->findAll();
        $listeCategorie=$this->categorieRepository->findAll();

        return $this->render('paiement/crypto.html.twig', [
            'crypto' =>$crypto,
             'montantTotal' => $facturation->getPrixTotale(),
            'liste_categorie'=>$listeCategorie,
            'categories'=> $listeCategorie,
        ]);
    }

}
