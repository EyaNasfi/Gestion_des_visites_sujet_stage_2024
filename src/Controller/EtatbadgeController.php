<?php

namespace App\Controller;

use App\Entity\EtatBadge;
use App\Form\EtatbadgeType;
use App\Repository\BadgeRepository;
use App\Repository\VisiteRepository;
use App\Repository\VisiteurRepository;
use App\Repository\EtatBadgeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DepartementRepository;
use App\Repository\TypeVisiteurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EtatbadgeController extends AbstractController
{
    #[Route('/etatbadge', name: 'app_etatbadge')]
    public function index(): Response
    {
        return $this->render('etatbadge/index.html.twig', [
            'controller_name' => 'EtatbadgeController',
        ]);
    }
    #[Route('/etatbadge/create', name: 'app_etatbadge_create')]
    public function create(Request $req,EntityManagerInterface $em,EtatBadgeRepository $rep,VisiteurRepository $vi,TypeVisiteurRepository $tv,VisiteRepository $vr ,DepartementRepository $dr,BadgeRepository $br,Security $security): Response
    {
        $user = $security->getUser();

        $etatb = new EtatBadge();
        $form = $this->createForm(EtatbadgeType::class,$etatb); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
        $form->handleRequest($req); //traitement de requete  , 
        $r=$rep->findAll();
        $ra=$vi->findAll();
        $rb=$tv->findAll();
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
                $em->persist($etatb); //T3awedh persist l'entité Reclamation fil entity manager.
                $em->flush(); //na3ml refresh f bd
                return $this->redirectToRoute('app_etatbadge_create');
            }
        
            return $this->render('etatbadge/index.html.twig', [
                'form' => $form->createView() , 'etats'=>$r ,'typevisis'=>$rb,'visis'=>$ra  ,'viss'=>$vr->findAll(),
                'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges,'user'=>$user
            ]);
    }
    #[Route('/etatbadge/show', name: 'app_show_etatbadge')]
    public function show(EtatBadgeRepository $rep,VisiteurRepository $vi,TypeVisiteurRepository $tv): Response
    {
        $ra=$vi->findAll();
        $rb=$tv->findAll();
        $r=$rep->findAll();
        return $this->render('typev/datatable.html.twig', [
'etats'=>$r ,'typevisis'=>$rb,'visis'=>$ra         ]);
    }
    #[Route('/etatbadge/edit/{id}', name: 'app_etatbadge_edit')]
    public function edit(Request $req,EntityManagerInterface $em,EtatBadgeRepository $rep,$id ): Response
    {
        $r=$rep->findAll();
        $p = $rep->find($id); //n3ml instance 
            $form = $this->createForm(EtatbadgeType::class, $p); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
            $form->handleRequest($req); //traitement de requete  , 
        
            if ($form->isSubmitted() && $form->isValid()) { //kn form valide 
                $em = $this->getDoctrine()->getManager(); //nakhedh entity manager eli ta3ml persist l'entite f bd
                $em->flush(); //na3ml refresh f bd
        
                return $this->redirectToRoute('app_show_etatbadge');
            }
            return $this->render('etatbadge/index.html.twig', [
                'form' => $form->createView()    ,'etats'=>$r 
        ]);
    }

    #[Route('/etatbadge/editer/{id}', name: 'app_etatbadge_editer')]
    public function editer(Request $req,EntityManagerInterface $em,VisiteurRepository $vi,TypeVisiteurRepository $tv,VisiteRepository $vr ,DepartementRepository $dr,BadgeRepository $br,EtatBadgeRepository $rep,$id ): Response
    {
        $r=$rep->findAll();
        $p = $rep->find($id); //n3ml instance 
            $form = $this->createForm(EtatbadgeType::class, $p); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
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
        
                return $this->redirectToRoute('app_eb_create');
            }
            return $this->render('theme/eb.html.twig', [
                'form' => $form->createView()    ,'etats'=>$r ,                'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges,

        ]);
    }

    #[Route('/etatbadge/deletee/{id}', name: 'app_etatbadge_deletee')]
    public function deletee(EtatBadgeRepository $etatb,$id ): Response
    {
        $r = $etatb->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($r);
        $em->flush();
        return $this->redirectToRoute('app_eb_create');
    }
    #[Route('/etatbadge/delete/{id}', name: 'app_etatbadge_delete')]
    public function delete(EtatBadgeRepository $etatb,$id ): Response
    {
        $r = $etatb->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($r);
        $em->flush();
        return $this->redirectToRoute('app_affichertyp');
    }


    #[Route('/etatbadge/createe', name: 'app_eb_create')]
    public function createe(Request $req,EntityManagerInterface $em,EtatBadgeRepository $rep,VisiteurRepository $vi,TypeVisiteurRepository $tv,VisiteRepository $vr ,DepartementRepository $dr,BadgeRepository $br,Security $security): Response
    {
        $user = $security->getUser();

        $etatb = new EtatBadge();
        $form = $this->createForm(EtatbadgeType::class,$etatb); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
        $form->handleRequest($req); //traitement de requete  , 
        $r=$rep->findAll();
        $ra=$vi->findAll();
        $rb=$tv->findAll();
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
                $em->persist($etatb); //T3awedh persist l'entité Reclamation fil entity manager.
                $em->flush(); //na3ml refresh f bd
                return $this->redirectToRoute('app_eb_create');
            }
        
            return $this->render('theme/eb.html.twig', [
                'form' => $form->createView() , 'etats'=>$r ,'typevisis'=>$rb,'visis'=>$ra  ,'viss'=>$vr->findAll(),
                'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges,'user'=>$user
            ]);
    }
}
