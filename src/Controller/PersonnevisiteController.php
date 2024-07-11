<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Entity\EtatBadge;
use App\Entity\PersonneVisite;
use App\Form\DepartType;
use App\Form\EtatbadgeType;
use App\Form\PvType;
use App\Repository\BadgeRepository;
use App\Repository\VisiteurRepository;
use App\Repository\EtatBadgeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DepartementRepository;
use App\Repository\PersonneVisiteRepository;
use App\Repository\TypeVisiteurRepository;
use App\Repository\VisiteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

class PersonnevisiteController extends AbstractController
{
    #[Route('/personnev', name: 'app_personnev')]
    public function index(): Response
    {
        return $this->render('departement/index.html.twig', [
            'controller_name' => 'DepartementController',
        ]);
    }
    #[Route('/personnev/create', name: 'app_personnev_create')]
    public function create(Request $req,Security $security,EntityManagerInterface $em,EtatBadgeRepository $rep,VisiteurRepository $vi,TypeVisiteurRepository $tv,DepartementRepository $dr,PersonneVisiteRepository $pvr,VisiteRepository $vr,BadgeRepository $br ): Response
    {
        $user = $security->getUser();
        $dep = new PersonneVisite();
        $form = $this->createForm(PvType::class,$dep); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
        $form->handleRequest($req); //traitement de requete  , 
        $r=$rep->findAll();
        $ra=$vi->findAll();
        $rb=$tv->findAll();
        $rc=$dr->findAll();
        $rd=$pvr->findAll();
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
                return $this->redirectToRoute('app_personnev_create');
            }
        
            return $this->render('personnevisite/index.html.twig', [
                'form' => $form->createView() , 'etats'=>$r ,'typevisis'=>$rb,'visis'=>$ra  ,'departs'=>$rc,'pvs'=>$rd,
                'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges,'user'=>$user

            ]);
    }
    #[Route('/personnev/show', name: 'app_show_personnev')]
    public function show(DepartementRepository $repo,EtatBadgeRepository $rep,VisiteurRepository $vi,TypeVisiteurRepository $tv,PersonneVisiteRepository $pvr,DepartementRepository $dr,VisiteurRepository $vr): Response
    {
        $r=$rep->findAll();
        $ra=$vi->findAll();
        $rb=$tv->findAll();
        $rc=$pvr->findAll();

        return $this->render('typev/datatable.html.twig', [
            'departements' => $repo->findAll(),'etats'=>$r ,'typevisis'=>$rb,'visis'=>$ra ,'pvs'=>$rc,'viss'=>$vr->findAll(), 
        ]);
    }
    #[Route('/personnev/edit/{id}', name: 'app_personnev_edit')]
    public function edit(Request $req,EntityManagerInterface $em,PersonneVisiteRepository $rep,$id ): Response
    {
        $r=$rep->findAll();
        $p = $rep->find($id); //n3ml instance 
            $form = $this->createForm(PvType::class, $p); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
            $form->handleRequest($req); //traitement de requete  , 
        
            if ($form->isSubmitted() && $form->isValid()) { //kn form valide 
                $em = $this->getDoctrine()->getManager(); //nakhedh entity manager eli ta3ml persist l'entite f bd
                $em->flush(); //na3ml refresh f bd
        
                return $this->redirectToRoute('app_personnev_create');
            }
            return $this->render('personnevisite/index.html.twig', [
                'form' => $form->createView()    ,'pvs'=>$r 
        ]);
    }

    
    #[Route('/personnev/delete/{id}', name: 'app_personnev_delete')]
    public function delete(PersonneVisiteRepository $etatb,$id ): Response
    {
        $r = $etatb->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($r);
        $em->flush();
        return $this->redirectToRoute('app_show_personnev');
    }
}
