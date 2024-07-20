<?php

namespace App\Controller;

use App\Form\TvType;
use App\Entity\TypeVisiteur;
use App\Repository\UserRepository;
use App\Repository\BadgeRepository;
use App\Repository\VisiteRepository;
use App\Repository\VisiteurRepository;
use App\Repository\EtatBadgeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DepartementRepository;
use App\Repository\TypeVisiteurRepository;
use App\Repository\PersonneVisiteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TypevController extends AbstractController
{

    #[Route('/typv', name: 'app_typv_create')]
    public function createtv(Request $req,EntityManagerInterface $em,TypeVisiteurRepository $rep,VisiteurRepository $vi,TypeVisiteurRepository $tv,DepartementRepository $dr,PersonneVisiteRepository $pvr,VisiteRepository $vr,BadgeRepository $br,Security $security ): Response
    {
        $user = $security->getUser();
        $typev = new TypeVisiteur();
        $form = $this->createForm(TvType::class,$typev); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
        $form->handleRequest($req); //traitement de requete  , 
        $r=$rep->findAll();
        $Visiteurs = $vi->createQueryBuilder('q')
        ->select('COUNT(q.idv)')
        ->getQuery()
        ->getSingleScalarResult(); 
    $Visites = $vr->createQueryBuilder('q')
        ->select('COUNT(q.idvisite)')
        ->getQuery()
        ->getSingleScalarResult(); 
    $departements = $dr->createQueryBuilder('q')
        ->select('COUNT(q.iddep)')
        ->getQuery()
        ->getSingleScalarResult(); 
    $badges = $br->createQueryBuilder('q')
        ->select('COUNT(q.idba)')
        ->getQuery()
        ->getSingleScalarResult();  
            if ($form->isSubmitted() && $form->isValid()) { //kn form valide 
                $em = $this->getDoctrine()->getManager(); //nakhedh entity manager eli ta3ml persist l'entite f bd
                $em->persist($typev); //T3awedh persist l'entité Reclamation fil entity manager.
                $em->flush(); //na3ml refresh f bd
                return $this->redirectToRoute('app_typv_create');
            }
        
            return $this->render('theme/typv.html.twig', [
                'form' => $form->createView() , 'typevisis'=>$r,
                'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges
                ,'user'=>$user
            ]);
    }
    #[Route('/typev', name: 'app_home')]
    public function index(VisiteurRepository $vi,TypeVisiteurRepository $tv,DepartementRepository $dr,PersonneVisiteRepository $pvr,VisiteRepository $vr,BadgeRepository $br,Security $security): Response
    {
        $Visiteurs = $vi->createQueryBuilder('q')
        ->select('COUNT(q.idv)')
        ->getQuery()
        ->getSingleScalarResult(); 
    $Visites = $vr->createQueryBuilder('q')
        ->select('COUNT(q.idvisite)')
        ->getQuery()
        ->getSingleScalarResult(); 
    $departements = $dr->createQueryBuilder('q')
        ->select('COUNT(q.iddep)')
        ->getQuery()
        ->getSingleScalarResult(); 
    $badges = $br->createQueryBuilder('q')
        ->select('COUNT(q.idba)')
        ->getQuery()
        ->getSingleScalarResult();  
        $user = $security->getUser();
     return $this->render('/typev/home.html.twig', [
        'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges,'user'=>$user

    ]);
    }
    #[Route('/typecreatee', name: 'app_typev_create')]
    public function create(Request $req,EntityManagerInterface $em,TypeVisiteurRepository $rep,VisiteurRepository $vi,TypeVisiteurRepository $tv,DepartementRepository $dr,PersonneVisiteRepository $pvr,VisiteRepository $vr,BadgeRepository $br,Security $security ): Response
    {
        $user = $security->getUser();
        $typev = new TypeVisiteur();
        $form = $this->createForm(TvType::class,$typev); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
        $form->handleRequest($req); //traitement de requete  , 
        $r=$rep->findAll();
        $Visiteurs = $vi->createQueryBuilder('q')
        ->select('COUNT(q.idv)')
        ->getQuery()
        ->getSingleScalarResult(); 
    $Visites = $vr->createQueryBuilder('q')
        ->select('COUNT(q.idvisite)')
        ->getQuery()
        ->getSingleScalarResult(); 
    $departements = $dr->createQueryBuilder('q')
        ->select('COUNT(q.iddep)')
        ->getQuery()
        ->getSingleScalarResult(); 
    $badges = $br->createQueryBuilder('q')
        ->select('COUNT(q.idba)')
        ->getQuery()
        ->getSingleScalarResult();  
            if ($form->isSubmitted() && $form->isValid()) { //kn form valide 
                $em = $this->getDoctrine()->getManager(); //nakhedh entity manager eli ta3ml persist l'entite f bd
                $em->persist($typev); //T3awedh persist l'entité Reclamation fil entity manager.
                $em->flush(); //na3ml refresh f bd
                return $this->redirectToRoute('app_typev_create');
            }
        
            return $this->render('typev/base.html.twig', [
                'form' => $form->createView() , 'typevisis'=>$r,
                'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges
                ,'user'=>$user
            ]);
    }
    #[Route('/typev/afficher', name: 'app_affichertyp')]
public function affiche(TypeVisiteurRepository $re,DepartementRepository $dr,VisiteurRepository $rr,EtatBadgeRepository $rep,PersonneVisiteRepository $pv,VisiteRepository $vr,Security $security,BadgeRepository $br,VisiteurRepository $vi,TypeVisiteurRepository $tv ){
    $r = $re->findAll();
    $ro=$rr->findAll();
    $ra=$rep->findAll();
    $user = $security->getUser();

    $Visiteurs = $vi->createQueryBuilder('q')
    ->select('COUNT(q.idv)')
    ->getQuery()
    ->getSingleScalarResult(); 
$Visites = $vr->createQueryBuilder('q')
    ->select('COUNT(q.idvisite)')
    ->getQuery()
    ->getSingleScalarResult(); 
$departements = $dr->createQueryBuilder('q')
    ->select('COUNT(q.iddep)')
    ->getQuery()
    ->getSingleScalarResult(); 
$badges = $br->createQueryBuilder('q')
    ->select('COUNT(q.idba)')
    ->getQuery()
    ->getSingleScalarResult();  
    return $this->render('typev/datatable.html.twig', [
        'typevisis'=>$r,'visis'=>$ro,'etats'=>$ra,'departementss'=>$dr->findAll(),'pvs'=>$pv->findAll(),'viss'=>$vr->findAll(),'badgess'=>$br->findAll(),
        'user'=>$user, //na3ml user l3li hna b login 3li fiha l'info user w 3b3ch n3ml render w tawedh l'info user 3li fiha l'info user w 3b3ch n3ml render w tawedh l'info user 3li fiha l'info user w 3b3ch n3ml render w tawedh l'info
        'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges

    
    ]);
}
    #[Route('/typev/supprimer/{id}', name: 'app_supprimertyp')]
    public function supprimer($id,TypeVisiteurRepository $re ){
        $r = $re->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($r);
        $em->flush();
        return $this->redirectToRoute('app_affichertyp');
    }  
    #[Route('/typev/supprime/{id}', name: 'app_supprimertypv')]
    public function supprime($id,TypeVisiteurRepository $re ){
        $r = $re->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($r);
        $em->flush();
        return $this->redirectToRoute('app_typv_create');
    }   



    #[Route('/typev/modifie/{id}', name: 'app_modifiertypv')]
    public function modifie(Request $req,$id, TypeVisiteurRepository $rep,DepartementRepository $dr,VisiteurRepository $rr,PersonneVisiteRepository $pv,VisiteRepository $vr,Security $security,BadgeRepository $br,VisiteurRepository $vi,TypeVisiteurRepository $tv){
        $p = $rep->find($id); //n3ml instance 
            $form = $this->createForm(TvType::class, $p); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
            $form->handleRequest($req); //traitement de requete  , 
            $Visiteurs = $vi->createQueryBuilder('q')
            ->select('COUNT(q.idv)')
            ->getQuery()
            ->getSingleScalarResult(); 
        $Visites = $vr->createQueryBuilder('q')
            ->select('COUNT(q.idvisite)')
            ->getQuery()
            ->getSingleScalarResult(); 
        $departements = $dr->createQueryBuilder('q')
            ->select('COUNT(q.iddep)')
            ->getQuery()
            ->getSingleScalarResult(); 
        $badges = $br->createQueryBuilder('q')
            ->select('COUNT(q.idba)')
            ->getQuery()
            ->getSingleScalarResult(); 
            if ($form->isSubmitted() && $form->isValid()) { //kn form valide 
                $em = $this->getDoctrine()->getManager(); //nakhedh entity manager eli ta3ml persist l'entite f bd
                $em->flush(); //na3ml refresh f bd
        
                return $this->redirectToRoute('app_typv_create');
            }
            return $this->render('theme/modiftv.html.twig', [
                'form' => $form->createView() ,'typevisis' => $rep->findAll()   ,        'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges
 
        ]);
    }
    #[Route('/typev/modifier/{id}', name: 'app_modifiertyp')]
    public function modifier(Request $req,$id, TypeVisiteurRepository $rep){
        $p = $rep->find($id); //n3ml instance 
            $form = $this->createForm(TvType::class, $p); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
            $form->handleRequest($req); //traitement de requete  , 
        
            if ($form->isSubmitted() && $form->isValid()) { //kn form valide 
                $em = $this->getDoctrine()->getManager(); //nakhedh entity manager eli ta3ml persist l'entite f bd
                $em->flush(); //na3ml refresh f bd
        
                return $this->redirectToRoute('app_affichertyp');
            }
            return $this->render('typev/base.html.twig', [
                'form' => $form->createView() ,'typevisis' => $rep->findAll()    
        ]);
    }
    
    }


