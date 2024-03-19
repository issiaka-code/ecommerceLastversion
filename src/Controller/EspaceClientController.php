<?php

namespace App\Controller;

use App\Entity\Facturation;
use App\Entity\ProduitAcheter;
use App\Repository\FacturationRepository;
use App\Repository\ProduitAcheterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/space')]
class EspaceClientController extends AbstractController
{
    #[Route('/compte', name: 'app_compte')]
    public function index(FacturationRepository $facturationRepository): Response
    {
       // $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();

        $email= $user->getEmail();



        $resultat= $facturationRepository->findBy(['email'=>$email]) ;

        $en_attente= $facturationRepository->findBy(['etat'=>'En attente','email'=>$email]);
        $liver= $facturationRepository->findBy(['etat'=>'livrer','email'=>$email]);
        $annuler= $facturationRepository->findBy(['etat'=>'annulée','email'=>$email]);


        return $this->render('espace_client/index.html.twig', [
            'facture' => $resultat,
            'nbr'=>sizeof($resultat),
            'liver'=>sizeof($liver),
            'annuler'=>sizeof($annuler),
            'enattente'=>sizeof($en_attente)
        ]);
    }

    #[Route('/compte/valider/{id}', name: 'app_valider')]
    public function validerFacture($id, Facturation $facturation,EntityManagerInterface $entityManager ): Response
    {
        $facturation->setEtat('validée');
        $entityManager->persist($facturation);
        $entityManager->flush();

        return $this->redirectToRoute('app_compte');
    }

    #[Route('/compte/annuller/{id}', name: 'app_annuller')]
    public function annullerFacture ($id, Facturation $facturation ,EntityManagerInterface $entityManager ): Response
    {
        $facturation->setEtat('annulée');
        $entityManager->persist($facturation);
        $entityManager->flush();

        return $this->redirectToRoute('app_compte');
    }

    #[Route('/voir/Commande/{id}', name: 'app_Commande')]
    public function voirCommande( ProduitAcheterRepository $produitAcheterRepository,FacturationRepository $facturationRepository,$id,Facturation $facture): Response
    {
       // $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();

        $email= $user->getEmail();
       // $email= 'hougniissiaka60@gmail.com';

        $resultat= $facturationRepository->findBy(['email'=>$email]) ;

        $en_attente= $facturationRepository->findBy(['etat'=>'En attente','email'=>$email]);
        $liver= $facturationRepository->findBy(['etat'=>'livrer','email'=>$email]);
        $annuler= $facturationRepository->findBy(['etat'=>'annulée','email'=>$email]);

        $paiement=$facture->getTypepaiement();
        $totale=$facture->getPrixTotale();

        $tab_produit = $produitAcheterRepository->findBy(['facture'=> $facture->getId()])  ;



        return $this->render('espace_client/voirCommande.html.twig', [
            'totale'=>$totale,
            'facture'=>$facture,
            'produit'=>$tab_produit,
            'nbr'=>sizeof($resultat),
            'liver'=>sizeof($liver),
            'annuler'=>sizeof($annuler),
            'enattente'=>sizeof($en_attente),
            'paiement'=>$paiement
        ]);

    }
}
