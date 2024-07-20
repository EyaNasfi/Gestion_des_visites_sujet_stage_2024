<?php

namespace App\Controller;

use App\Entity\Visiteur;
use App\Form\VisiteurType;
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

class VisiteurController extends AbstractController
{
    #[Route('/visiteur', name: 'app_visiteur')]
    public function index(): Response
    {
        return $this->render('visiteur/index.html.twig', [
            'controller_name' => 'VisiteurController',
        ]);
    }
    #[Route('/visiteurcreate', name: 'app_visiteur_create')]
    public function create(Request $req,EntityManagerInterface $em,VisiteurRepository $rep ,VisiteRepository $vr,Security $security,DepartementRepository $dr,BadgeRepository $br): Response
    {
        $visiteur = new Visiteur();
        $form = $this->createForm(VisiteurType::class,$visiteur); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
        $form->handleRequest($req);
        $Visiteurs = $rep->createQueryBuilder('q')
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
        $r=$rep->findAll();
        $user = $security->getUser();

            if ($form->isSubmitted() && $form->isValid()) {
                dump($visiteur->getIdtype()); //kn form valide 
                $em = $this->getDoctrine()->getManager(); //nakhedh entity manager eli ta3ml persist l'entite f bd
                $em->persist($visiteur); //T3awedh persist l'entité Reclamation fil entity manager.
                $em->flush(); //na3ml refresh f bd
                return $this->redirectToRoute('app_visiteur_create');
            }
        
            return $this->render('visiteur/createv.html.twig', [
                'fo' => $form->createView() , 'visis'=>$r,'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges,'user'=>$user
            ]);
    }
    #[Route('/vicreate', name: 'app_v_create')]
    public function createe(Request $req,EntityManagerInterface $em,VisiteurRepository $rep ,VisiteRepository $vr,Security $security,DepartementRepository $dr,BadgeRepository $br): Response
    {
        $visiteur = new Visiteur();
        $form = $this->createForm(VisiteurType::class,$visiteur); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
        $form->handleRequest($req);
        $Visiteurs = $rep->createQueryBuilder('q')
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
        $r=$rep->findAll();
        $user = $security->getUser();

            if ($form->isSubmitted() && $form->isValid()) {
                dump($visiteur->getIdtype()); //kn form valide 
                $em = $this->getDoctrine()->getManager(); //nakhedh entity manager eli ta3ml persist l'entite f bd
                $em->persist($visiteur); //T3awedh persist l'entité Reclamation fil entity manager.
                $em->flush(); //na3ml refresh f bd
                return $this->redirectToRoute('app_v_create');
            }
        
            return $this->render('theme/visiteur.html.twig', [
                'fo' => $form->createView() , 'visis'=>$r,'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges,'user'=>$user
            ]);
    }
    #[Route('/visiteurupdat/{id}', name: 'app_vi_update')]
    public function updat(Request $req,EntityManagerInterface $em,VisiteurRepository $rep,$id,VisiteRepository $vr,DepartementRepository $dr,BadgeRepository $br,EtatBadgeRepository $eb): Response
    {
        $visiteur = $rep->find($id);
        $form = $this->createForm(VisiteurType::class,$visiteur); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
        $form->handleRequest($req); 
        $Visiteurs = $rep->createQueryBuilder('q')
            ->select('COUNT(q.idv)')
            ->getQuery()
            ->getSingleScalarResult();
        $etats = $eb->createQueryBuilder('q')
        ->select('COUNT(q.idetat)')
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
        $r=$rep->findAll();
        $r=$rep->findAll();
            if ($form->isSubmitted() && $form->isValid()) {
                dump($visiteur->getIdtype()); //kn form valide 
                $em = $this->getDoctrine()->getManager(); //nakhedh entity manager eli ta3ml persist l'entite f bd
                $em->persist($visiteur); //T3awedh persist l'entité Reclamation fil entity manager.
                $em->flush(); //na3ml refresh f bd
                return $this->redirectToRoute('app_v_create');
            }
            return $this->render('theme/modifvisiteur.html.twig', [
                'fo' => $form->createView() ,'visis' => $rep->findAll()    
                ,'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges,'etats'=>$etats,
        ]);
    }
    #[Route('/visiteurupdate/{id}', name: 'app_visiteur_update')]
    public function update(Request $req,EntityManagerInterface $em,VisiteurRepository $rep,$id,VisiteRepository $vr,DepartementRepository $dr,BadgeRepository $br,EtatBadgeRepository $eb): Response
    {
        $visiteur = $rep->find($id);
        $form = $this->createForm(VisiteurType::class,$visiteur); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
        $form->handleRequest($req); 
        $Visiteurs = $rep->createQueryBuilder('q')
            ->select('COUNT(q.idv)')
            ->getQuery()
            ->getSingleScalarResult();
        $etats = $eb->createQueryBuilder('q')
        ->select('COUNT(q.idetat)')
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
        $r=$rep->findAll();
        $r=$rep->findAll();
            if ($form->isSubmitted() && $form->isValid()) {
                dump($visiteur->getIdtype()); //kn form valide 
                $em = $this->getDoctrine()->getManager(); //nakhedh entity manager eli ta3ml persist l'entite f bd
                $em->persist($visiteur); //T3awedh persist l'entité Reclamation fil entity manager.
                $em->flush(); //na3ml refresh f bd
                return $this->redirectToRoute('app_visiteur_show');
            }
            return $this->render('visiteur/createv.html.twig', [
                'fo' => $form->createView() ,'visis' => $rep->findAll()    
                ,'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges,'etats'=>$etats,
        ]);
    }
    
    #[Route('/visiteurshow', name: 'app_visiteur_show')]
    public function show(Request $req,EntityManagerInterface $em,VisiteurRepository $rep,TypeVisiteurRepository $rp,VisiteRepository $vr,DepartementRepository $dr,BadgeRepository $br,EtatBadgeRepository $eb,PersonneVisiteRepository $pvs ): Response
    {
        $pvs = $pvs->createQueryBuilder('q')
            ->select('COUNT(q.matricule)')
            ->getQuery()
            ->getSingleScalarResult();
        $Visiteurs = $rep->createQueryBuilder('q')
            ->select('COUNT(q.idv)')
            ->getQuery()
            ->getSingleScalarResult();
        $etats = $eb->createQueryBuilder('q')
        ->select('COUNT(q.idetat)')
        ->getQuery()
        ->getSingleScalarResult(); 
        $viss = $vr->createQueryBuilder('q')
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
        $r=$rep->findAll();
        $re=$rp->findAll();
        return $this->render('typev/datatable.html.twig', [
            'controller_name' => 'VisiteurController', 'visis'=>$r,'typevisis'=>$re,
            'visiteurs' => $Visiteurs,'viss'=>$viss,'departements'=>$departements,'badges'=>$badges,'etats'=>$etats,'pvs'=>$pvs,

        ]);
    }
    #[Route('/visiteurdelete/{id}', name: 'app_visiteur_delete')]
    public function delete(Request $req,EntityManagerInterface $em,VisiteurRepository $rep,$id): Response
    {
        $visiteur = $rep->find($id);
        $em->remove($visiteur);
        $em->flush();
        return $this->redirectToRoute('app_visiteur_show');
    }
    #[Route('/visiteursupp/{id}', name: 'app_vi_delete')]
    public function delet(Request $req,EntityManagerInterface $em,VisiteurRepository $rep,$id): Response
    {
        $visiteur = $rep->find($id);
        $em->remove($visiteur);
        $em->flush();
        return $this->redirectToRoute('app_v_create');
    }
}
