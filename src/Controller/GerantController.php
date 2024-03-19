<?php

namespace App\Controller;

use App\Repository\BanqueRepository;
use App\Repository\CryptoRepository;
use App\Repository\FacturationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/admin')]
class GerantController extends AbstractController
{
    #[Route('/gerant', name: 'app_gerant')]
    public function index(FacturationRepository $facturationRepository): Response
    {


        $resultat= $facturationRepository->findAll();

        $en_attente= $facturationRepository->findBy(['etat'=>'En attente']);
        $liver= $facturationRepository->findBy(['etat'=>'livrer']);
        $annuler= $facturationRepository->findBy(['etat'=>'annuller']);

        return $this->render('gerant/index.html.twig', [
            'facture' => $resultat,
            'nbr'=>sizeof($resultat),
            'liver'=>sizeof($liver),
            'annuler'=>sizeof($annuler),
            'enattente'=>sizeof($en_attente)
        ]);
    }

    #[Route('/coordonner', name: 'app_coordonner')]
    public function coordonner(BanqueRepository $banqueRepository ,FacturationRepository $facturationRepository,CryptoRepository $cryptoRepository): Response
    {


        $resul=$banqueRepository->findAll();

        $resultat= $facturationRepository->findAll();
        $en_attente= $facturationRepository->findBy(['etat'=>'En attente']);
        $liver= $facturationRepository->findBy(['etat'=>'livrer']);
        $annuler= $facturationRepository->findBy(['etat'=>'annuller']);

        $crypto=$cryptoRepository->findAll();



        return $this->render('/gerant/coordonner/index.html.twig', [

            'rib' => $resul,

            'nbr'=>sizeof($resultat),
            'liver'=>sizeof($liver),
            'annuler'=>sizeof($annuler),
            'enattente'=>sizeof($en_attente),
            'crypto' =>$crypto

        ]);
    }
}
