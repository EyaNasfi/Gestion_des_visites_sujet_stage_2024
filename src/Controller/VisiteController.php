<?php

namespace App\Controller;

use DateTime;
use App\Form\PvType;
use App\Entity\Badge;
use App\Entity\Visite;
use App\Entity\Visiteur;
use App\Form\VisiteType;
use App\Form\VisiteurType;
use App\Entity\PersonneVisite;
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

class VisiteController extends AbstractController
{
    #[Route('/visite', name: 'app_visite')]
    public function index(): Response
    {
        return $this->render('visite/index.html.twig', [
            'controller_name' => 'VisiteController',
        ]);
    }


    #[Route('/charts', name: 'app_charts')]
    public function charts(EtatBadgeRepository $rep,VisiteurRepository $vi,TypeVisiteurRepository $tv,DepartementRepository $dr,PersonneVisiteRepository $pvr,VisiteRepository $vr,BadgeRepository $br,Security $security): Response
    {
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
        return $this->render('/charts.html.twig', [
            'controller_name' => 'VisiteController',                'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges,'user'=>$user

        ]);
    }
    #[Route('/visite/create', name: 'app_visite_create')]
    public function create(Request $req,EntityManagerInterface $em,EtatBadgeRepository $rep,VisiteurRepository $vi,TypeVisiteurRepository $tv,DepartementRepository $dr,PersonneVisiteRepository $pvr,VisiteRepository $vr,BadgeRepository $br,Security $security ): Response
    {
        $user = $security->getUser();
        $vis=new Visiteur();
        $dep = new Visite();
        $etat = $br->find(2); 
        $dep->setIdbadge($etat);
        $form = $this->createForm(VisiteType::class,$dep); 
        $fo = $this->createForm(VisiteurType::class,$vis);
        $fo->handleRequest($req);//n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
        $form->handleRequest($req); 
        $r=$rep->findAll();
        $ra=$vi->findAll();
        $rb=$tv->findAll();
        $rc=$dr->findAll();
        $rd=$pvr->findAll();
        $re=$vr->findAll();
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
        if ($fo->isSubmitted() && $fo->isValid()) { //kn form valide 
            $em = $this->getDoctrine()->getManager(); //nakhedh entity manager eli ta3ml persist l'entite f bd
            $em->persist($vis); //T3awedh persist l'entité Reclamation fil entity manager.
            $em->flush(); //na3ml refresh f bd
            return $this->redirectToRoute('app_visite_create');

        } 
            if ($form->isSubmitted() && $form->isValid()) { //kn form valide 
                $em = $this->getDoctrine()->getManager(); //nakhedh entity manager eli ta3ml persist l'entite f bd
                $em->persist($dep); //T3awedh persist l'entité Reclamation fil entity manager.
                $em->flush(); //na3ml refresh f bd
                return $this->redirectToRoute('app_visite_create');
            }
        
            return $this->render('visite/index.html.twig', [
                'f'=>$fo->createView(),
                'form' => $form->createView() , 'etats'=>$r ,'typevisis'=>$rb,'visis'=>$ra  ,'departs'=>$rc,'pvs'=>$rd,'viss'=>$re,
                'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges,'user'=>$user
            ]);
    }
    #[Route('/visite/show', name: 'app_show_visite')]
    public function show(DepartementRepository $repo,EtatBadgeRepository $rep,VisiteurRepository $vi,TypeVisiteurRepository $tv,PersonneVisiteRepository $pvr,DepartementRepository $dr,VisiteRepository $vr): Response
    {
        $r=$rep->findAll();
        $ra=$vi->findAll();
        $rb=$tv->findAll();
        $rc=$pvr->findAll();
        
        return $this->render('typev/datatable.html.twig', [
            'departements' => $repo->findAll(),'etats'=>$r ,'typevisis'=>$rb,'visis'=>$ra ,'pvs'=>$rc ,'viss'=>$vr->findAll()
        ]);
    }
    #[Route('/visite/edit/{id}', name: 'app_visite_edit')]
    public function edit(Request $req,EntityManagerInterface $em,VisiteRepository $rep,$id ): Response
    {
        $r=$rep->findAll();
        $p = $rep->find($id); //n3ml instance 
            $form = $this->createForm(VisiteType::class, $p); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
            $form->handleRequest($req); //traitement de requete  , 
        
            if ($form->isSubmitted() && $form->isValid()) { //kn form valide 
                $em = $this->getDoctrine()->getManager(); //nakhedh entity manager eli ta3ml persist l'entite f bd
                $em->flush(); //na3ml refresh f bd
        
                return $this->redirectToRoute('app_visite_create');
            }
            return $this->render('visite/index.html.twig', [
                'form' => $form->createView()    ,'viss'=>$r 
        ]);
    }

    
    #[Route('/visite/delete/{id}', name: 'app_visite_delete')]
    public function delete(VisiteRepository $etatb,$id ): Response
    {
        $r = $etatb->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($r);
        $em->flush();
        return $this->redirectToRoute('app_show_visite');
    }
    #[Route('/visite/editer/{id}', name: 'app_visite_editer')]
    public function editer(Request $req,VisiteurRepository $vi,TypeVisiteurRepository $tv,DepartementRepository $dr,PersonneVisiteRepository $pvr,VisiteRepository $vr,BadgeRepository $br,EntityManagerInterface $em,VisiteRepository $rep,$id ): Response
    {
        $r=$rep->findAll();
        $p = $rep->find($id); //n3ml instance 
            $form = $this->createForm(VisiteType::class, $p); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
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
        
                return $this->redirectToRoute('app_visite_createe');
            }
            return $this->render('theme/visite.html.twig', [
                'form' => $form->createView()    ,'viss'=>$r ,                'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges

        ]);
    }
    #[Route('/visite/deletee/{id}', name: 'app_visite_deletee')]
    public function deletee(VisiteRepository $etatb,$id ): Response
    {
        $r = $etatb->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($r);
        $em->flush();
        return $this->redirectToRoute('app_visitee_create');
    }
    #[Route('/visite/createeee', name: 'app_visitee_create')]
    public function creat(Request $req,EntityManagerInterface $em,EtatBadgeRepository $rep,VisiteurRepository $vi,TypeVisiteurRepository $tv,DepartementRepository $dr,PersonneVisiteRepository $pvr,VisiteRepository $vr,BadgeRepository $br,Security $security ): Response
    {
        $user = $security->getUser();
        $vis=new Visiteur();
        $dep = new Visite();
        $etat = $br->find(2); 
        $dep->setIdbadge($etat);
        $form = $this->createForm(VisiteType::class,$dep); 
        $fo = $this->createForm(VisiteurType::class,$vis);
        $fo->handleRequest($req);//n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
        $form->handleRequest($req); 
        $r=$rep->findAll();
        $ra=$vi->findAll();
        $rb=$tv->findAll();
        $rc=$dr->findAll();
        $rd=$pvr->findAll();
        $re=$vr->findAll();
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
        if ($fo->isSubmitted() && $fo->isValid()) { //kn form valide 
            $em = $this->getDoctrine()->getManager(); //nakhedh entity manager eli ta3ml persist l'entite f bd
            $em->persist($vis); //T3awedh persist l'entité Reclamation fil entity manager.
            $em->flush(); //na3ml refresh f bd
            return $this->redirectToRoute('app_visitee_create');

        } 
            if ($form->isSubmitted() && $form->isValid()) { //kn form valide 
                $em = $this->getDoctrine()->getManager(); //nakhedh entity manager eli ta3ml persist l'entite f bd
                $em->persist($dep); //T3awedh persist l'entité Reclamation fil entity manager.
                $em->flush(); //na3ml refresh f bd
                return $this->redirectToRoute('app_visite_create');
            }
        
            return $this->render('theme/visite.html.twig', [
                'f'=>$fo->createView(),
                'form' => $form->createView() , 'etats'=>$r ,'typevisis'=>$rb,'visis'=>$ra  ,'departs'=>$rc,'pvs'=>$rd,'viss'=>$re,
                'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges,'user'=>$user
            ]);
    }
}