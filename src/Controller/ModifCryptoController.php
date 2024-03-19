<?php

namespace App\Controller;

use App\Entity\Crypto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Facturation;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\Persistence\ManagerRegistry;
class ModifCryptoController extends AbstractController
{
    #[Route('/modif/crypto/{id}', name: 'app_modif_crypto')]
    public function index(ManagerRegistry $doctrine,$id,Crypto $crypto ): Response
    {

        $repository2= $doctrine->getRepository(Facturation::class);

        $resultat= $repository2->findAll();
        $en_attente= $repository2->findBy(['etat'=>'En attente']);
        $liver= $repository2->findBy(['etat'=>'livrer']);
        $annuler= $repository2->findBy(['etat'=>'annuller']);

        return $this->render('/gerant/modif_crypto/index.html.twig', [
            'crypto' =>$crypto,

            'nbr'=>sizeof($resultat),
           'liver'=>sizeof($liver),
           'annuler'=>sizeof($annuler),
           'enattente'=>sizeof($en_attente),
        ]);
    }



    #[Route('/modification/crypto', name: 'app_traitement_crypto')]
    public function  traitement_crypto (ManagerRegistry $doctrine, Request $request ): Response
    {


        $id=$request->get('identifiant');

        $addresse=$request->get('adresse');
        $type=$request->get('type');



        $crypto=$doctrine->getRepository(Crypto::class)
        ->findOneBy(['id' => $id]);

       // dd($crypto);

        $crypto->setAdresse($addresse);
        $crypto->settype($type);

        $entityManager=$doctrine->getManager();
        $entityManager->persist($crypto);
        $entityManager->flush();

        return $this->redirectToRoute('app_coordonner');


    }
}
