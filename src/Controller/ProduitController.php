<?php

namespace App\Controller;

use App\Entity\Banque;
use App\Entity\Crypto;
use App\Entity\Facturation;
use App\Entity\Produit;
use App\Entity\ProduitAcheter;
//use App\Entity\User;
use App\Entity\User;
use App\Repository\CategorieRepository;
use App\Repository\ParamettreRepository;
use App\Repository\ProduitRepository;
//use App\Repository\UserRepository;
use App\Repository\UserRepository;
use App\Security\ConnexionAuthenticator;
use App\Services\Sendmail;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class ProduitController extends AbstractController
{
    private  ProduitRepository $produitRepository;
    private  CategorieRepository $categorieRepository;
    private EntityManagerInterface $entityManager;
    private  ParamettreRepository $paramettreRepository;
   private UserRepository $userRepository;
   private Sendmail $sendmail;
    public  function __construct(Sendmail $sendmail,UserRepository $userRepository,ParamettreRepository $paramettreRepository,EntityManagerInterface $entityManager,CategorieRepository $categorieRepository,ProduitRepository $produitRepository )
    {
       $this->produitRepository = $produitRepository;
       $this->categorieRepository = $categorieRepository;
       $this->entityManager= $entityManager;
       $this->paramettreRepository= $paramettreRepository;
       $this->userRepository= $userRepository;
       $this->sendmail = $sendmail;
    }
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
       $topproduit= $this->produitRepository->findBy(['toproduit'=>true]);
       $Promotion= $this->produitRepository->findBy(['promotion'=>true]);
        $promotionAcceuil= $this->produitRepository->findBy(['Section'=>'bon']);


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



        $vedette = $this->produitRepository->findBy(['isvedette' =>true]);
        $boutique = $this->produitRepository->findBy([], ['id' => 'DESC'], 30);
        $slider1=  $this->produitRepository->findOneBy(['lier'=>1]);
        $slider2=  $this->produitRepository->findOneBy(['lier'=>2]);
        $slider3=  $this->produitRepository->findOneBy(['lier'=>3]);

        return $this->render('produit/index.html.twig', [
            'toproduit' => $topproduit,
            'promotion' => $Promotion,
            'categories' => $listeCategorie,
            'vedette' => $vedette,
            'boutique' => $boutique,
            'paramettre'=> $this->paramettreRepository->findAll(),
            'promotionAcceuil' => $promotionAcceuil,
            'form' => $form->createView(),
            'slider1'=> $slider1,
            'slider2'=> $slider2,
            'slider3'=> $slider3,


        ]);
    }

    #[Route('/detail/{id}', name: 'app_detail')]
    public function detailProduit(Produit $produit,$id,Request $request): Response
    {
        $categoryName = $produit->getCategorie()->getNomcategorie();
        $idCat = $produit->getCategorie()->getId();
        $productAutre = $this->produitRepository->findBy(['categorie'=> $idCat ],limit:4);
        $recent = $this->produitRepository->findBy(['toproduit'=>true ],limit:3);
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

        $listeCategorie=$this->categorieRepository->findAll();

        return $this->render('produit/details.html.twig', [
            'produit' => $produit,
            'categorieproduit'=>$categoryName,
            'autre'=> $productAutre,
            'categories'=>$listeCategorie,
            'paramettre'=> $this->paramettreRepository->findAll(),
            'form' => $form->createView(),
            'recent'=> $recent,


        ]);
    }

    #[Route('/shop/{categorie}', name: 'app_shop')]
    public function details($categorie,PaginatorInterface $paginator,Request $request): Response
    {

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

        $boutique=[];
        if ($categorie == 0 )
        {
            $boutique = $this->produitRepository->findBy([], ['id' => 'DESC']);
        }else{
            $boutique = $this->produitRepository->findBy(['categorie'=>$categorie], ['id' => 'DESC']);
        }

        $boutique = $paginator->paginate(
            $boutique,
            $request->get('page', 1),
            35
        );

        return $this->render('produit/shop.html.twig', [
            'categories' => $listeCategorie,
            'boutique' => $boutique,
            'form' => $form->createView(),
            'paramettre'=> $this->paramettreRepository->findAll(),

        ]);
    }


    #[Route('/panier', name: 'app_panier')]
    public function panier(Request $request): Response
    {
        $listeCategorie=$this->categorieRepository->findAll();
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


        return $this->render('produit/panier.html.twig',[
            'liste_categorie'=>$listeCategorie,
            'form' => $form->createView(),
            'paramettre'=> $this->paramettreRepository->findAll(),
            'categories'=> $listeCategorie,


        ]);
    }

    #[Route('/info/produit/{id}', name: 'app_info_produit')]
    public function infoProduit(Produit $produit, $id): JsonResponse
    {
        // Supposez que $produit est déjà récupéré à partir de la base de données avec l'ID donné

        $response = new JsonResponse([
            'nom' => $produit->getNomproduit(),
            'image' => $produit->getImageproduit(),
            'prix' => $produit->getPrixproduit()
        ]);

        return $response;
    }

    #[Route('/acheter', name: 'app_acheter')]
    public function acheter(Request $request): Response
    {
        $panierJson = $request->get('panier');
        $panier = json_decode($panierJson, true);

        $montantTotal = 0;

        // Parcourez le panier et calculez le montant total
        foreach ($panier as $produit) {
            // Ajoutez le sous-total de ce produit au montant total
            $montantTotal += floatval($produit['prix']) * floatval($produit['quantite']);
        }

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

        $listeCategorie=$this->categorieRepository->findAll();
        if (isset($_POST['commander']))
        {
            $panierJson = $request->get('panier');
            $panier = json_decode($panierJson, true);

            $nom = $request->get('username');
            $prenom = $request->get('prenom');
            $phone = $request->get('phone');
            $pays = $request->get('pays'); // Notez que vous avez deux champs avec le même nom "phone"
            $ville = $request->get('ville');
            $adresse = $request->get('adresse');
            $subject = $request->get('subject');
            $email = $request->get('email');
            $password = 'password';
            $message = $request->get('message');
            $typePaiementSelect = 'Virement bancaire';

            $personne = [ 'nom'=>$nom,'prenom'=> $prenom , 'phone'=>$phone , 'ville'=>$ville , 'pays'=>$pays , 'adresse'=>$adresse,'email'=>$email ];
            $this->sendmail->sendEmailCommande($email,$panier,$personne);
            $this->sendmail->sendEmailCommande('amshopnow@allagence.com',$panier,$personne);
            return $this->redirectToRoute('app_paiement',['email'=>$email]);
        }


        return $this->render('produit/acheter.html.twig',[
            'montantTotal' => $montantTotal,
            'panier'=>$panier,
            'liste_categorie'=>$listeCategorie,
            'paramettre'=> $this->paramettreRepository->findAll(),
            'form' => $form->createView(),
            'categories'=> $listeCategorie,

        ]);
    }

    #[Route('/paiement/{email}', name: 'app_paiement')]
    public function paiement($email,Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {


//        $user_recup=$this->userRepository
//            ->findOneBy(['email' => $email]);
//
//        $montantTotal = 0;

        // Parcourez le panier et calculez le montant total
//        foreach ($panier as $produit) {
//            // Ajoutez le sous-total de ce produit au montant total
//            $montantTotal += floatval($produit['prix']) * floatval($produit['quantite']);
//        }

//        if(!$user_recup)
//        {
//            $user = new User();
//            // encode the plain password
//            $user->setPassword(
//                $userPasswordHasher->hashPassword(
//                    $user,
//                    $password
//                ));
//            $user->setEmail($email);
//            $user->setNom($nom);
//            $user->setPrenom($password);
//            $user->setPhone($phone);
//            $user->setPays($pays);
//            $user->setVille($ville);
//            $this->entityManager->persist($user);
//
//
//            $facturation=new Facturation();
//            $facturation->setEmail($email);
//            $facturation->setNom($nom);
//            $facturation->setPrenom($prenom);
//            $facturation->setProduit('bon');
//            $facturation->setTel($phone);
//            $facturation->setQuantite(sizeof($panier));
//            $facturation->setAdresselivraison($adresse);
//            $facturation->setTypepaiement($typePaiementSelect);
//            $facturation->setPrixTotale(strval($montantTotal));
//            $facturation->setVille($ville);
//            $facturation->setPays($pays);
//
//            $this->entityManager->persist($facturation);
//            $this->entityManager->flush();
//
//            foreach($panier as $produit)
//            {
//                $produitAcheter= new ProduitAcheter();
//                $valeur = $this->produitRepository->find($produit['id']);
//                $produitAcheter->setProduit($valeur);
//                $produitAcheter->setQuantite($produit['quantite']);
//                $produitAcheter->setFacture($facturation);
//                $this->entityManager->persist($produitAcheter);
//                $this->entityManager->flush();
//
//            }
//
//
//
//        }



//        $listeCategorie=$this->categorieRepository->findAll();
//
//        return $this->render('produit/acheter.html.twig',[
//            'montantTotal' => $montantTotal,
//            'liste_categorie'=>$listeCategorie,
//            'categories'=> $listeCategorie,
//        ]);
        $categorie = $this->categorieRepository->findAll();
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


        return $this->render('produit/confirmation.html.twig',[
         'personne' => $email,
            'categories' => $categorie,
            'form' => $form->createView(),
            'paramettre'=> $this->paramettreRepository->findAll(),
       ]);

    }


    #[Route('/recherche/{valeur}', name: 'app_recherche')]
    public function recherche($valeur,PaginatorInterface $paginator,Request $request): Response
    {
        $categorie = $this->categorieRepository->findAll();
        $resul=$this->produitRepository->Recherche($valeur);
        $resul = $paginator->paginate(
            $resul,
            $request->get('page', 1),
            35
        );

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

        return $this->render('produit/recherche.html.twig',[
            'boutique'=>$resul,
            'categories' => $categorie,
            'form' => $form->createView(),
            'paramettre'=> $this->paramettreRepository->findAll(),

        ]) ;
    }

}
