<?php

namespace App\Controller;
use App\Entity\Facturation;
use App\Entity\Banque;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModifCompteController extends AbstractController
{
    #[Route('/modif/compte', name: 'app_modif_compte')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Banque::class);

        $resul=$repository->findAll();

        $repository2= $doctrine->getRepository(Facturation::class);

        $resultat= $repository2->findAll();
        $en_attente= $repository2->findBy(['etat'=>'En attente']);
        $liver= $repository2->findBy(['etat'=>'livrer']);
        $annuler= $repository2->findBy(['etat'=>'annuller']);


        return $this->render('/gerant/modif_compte/index.html.twig', [
             'rib' => $resul,

            'nbr'=>sizeof($resultat),
           'liver'=>sizeof($liver),
           'annuler'=>sizeof($annuler),
           'enattente'=>sizeof($en_attente),
        ]);
    }

    #[Route('/modification', name: 'app_traitement_modif')]
    public function  traitement_modiuf (ManagerRegistry $doctrine, Request $request ): Response
    {


        $nombanque=$request->get('pays');
        //dd($pays);
        $addresse=$request->get('adresse');
        $desti=$request->get('desti');
        $bic=$request->get('bic');

        $banque=$doctrine->getRepository(Banque::class)
        ->findOneBy(['id' => 1]);


        $banque->setAdresse($addresse);
        $banque->setDesti($desti);
        $banque->setBanque($nombanque);
        $banque->setBic($bic);

        $entityManager=$doctrine->getManager();
        $entityManager->persist($banque);
        $entityManager->flush();

        return $this->redirectToRoute('app_coordonner');


    }

}
