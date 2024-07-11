<?php

namespace App\Controller;

use App\Form\DepartType;
use App\Entity\EtatBadge;
use App\Entity\Departement;
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

class DepartementController extends AbstractController
{
    #[Route('/departement', name: 'app_departement')]
    public function index(): Response
    {
        return $this->render('departement/index.html.twig', [
            'controller_name' => 'DepartementController',
        ]);
    }
    #[Route('/departement/create', name: 'app_departement_create')]
    public function create(Request $req,EntityManagerInterface $em,Security $security,EtatBadgeRepository $rep,VisiteurRepository $vi,TypeVisiteurRepository $tv,DepartementRepository $dr,VisiteRepository $vr,BadgeRepository $br ): Response
    {
        $user = $security->getUser();
        $dep = new Departement();
        $form = $this->createForm(DepartType::class,$dep); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
        $form->handleRequest($req); //traitement de requete  , 
        $r=$rep->findAll();
        $ra=$vi->findAll();
        $rb=$tv->findAll();
        $rc=$dr->findAll();
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
                $em->persist($dep); //T3awedh persist l'entité Reclamation fil entity manager.
                $em->flush(); //na3ml refresh f bd
                return $this->redirectToRoute('app_departement_create');
            }
        
            return $this->render('departement/index.html.twig', [
                'form' => $form->createView() , 'etats'=>$r ,'typevisis'=>$rb,'visis'=>$ra  ,'departs'=>$rc,
                'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges,'user'=>$user

            ]);
    }
    #[Route('/departement/show', name: 'app_show_departement')]
    public function show(DepartementRepository $repo,EtatBadgeRepository $rep,VisiteurRepository $vi,TypeVisiteurRepository $tv): Response
    {
        $r=$rep->findAll();
        $ra=$vi->findAll();
        $rb=$tv->findAll();
        return $this->render('typev/datatable.html.twig', [
            'departements' => $repo->findAll(),'etats'=>$r ,'typevisis'=>$rb,'visis'=>$ra  
        ]);
    }
    #[Route('/departement/edit/{id}', name: 'app_departement_edit')]
    public function edit(Request $req,EntityManagerInterface $em,DepartementRepository $rep,$id ): Response
    {
        $r=$rep->findAll();
        $p = $rep->find($id); //n3ml instance 
            $form = $this->createForm(DepartType::class, $p); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
            $form->handleRequest($req); //traitement de requete  , 
        
            if ($form->isSubmitted() && $form->isValid()) { //kn form valide 
                $em = $this->getDoctrine()->getManager(); //nakhedh entity manager eli ta3ml persist l'entite f bd
                $em->flush(); //na3ml refresh f bd
        
                return $this->redirectToRoute('app_show_department');
            }
            return $this->render('etatbadge/index.html.twig', [
                'form' => $form->createView()    ,'etats'=>$r 
        ]);
    }

    
    #[Route('/departement/delete/{id}', name: 'app_departement_delete')]
    public function delete(DepartementRepository $etatb,$id ): Response
    {
        $r = $etatb->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($r);
        $em->flush();
        return $this->redirectToRoute('app_show_department');
    }
}
