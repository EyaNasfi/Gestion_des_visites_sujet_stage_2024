<?php

namespace App\Controller;
use Dompdf\Dompdf;
use App\Form\TvType;
use App\Entity\Badge;
use App\Form\BadgeType;
use setasign\Fpdi\Fpdi;
use App\Form\BadgeeType;
use App\Entity\EtatBadge;
use App\Repository\BadgeRepository;
use App\Repository\VisiteRepository;
use App\Repository\VisiteurRepository;
use App\Repository\EtatBadgeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DepartementRepository;
use App\Repository\TypeVisiteurRepository;
use App\Repository\PersonneVisiteRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BadgeController extends AbstractController
{
    #[Route('/badge', name: 'app_badge')]
    public function index(): Response
    {
        return $this->render('badge/index.html.twig', [
            'controller_name' => 'BadgeController',
        ]);
    }
    #[Route('/badgee/{idba}', name: 'app_badgee')]
    public function badgee(BadgeRepository $rep,Request $request,$idba,Security $security): Response
    {
        $user = $security->getUser();

        $q = $rep->find($idba);
        $idbadge = $request->query->get('code');
$idbad=$request->query->get('idba');
        return $this->render('badge/badge.html.twig', [
            'controller_name' => 'BadgeController',
            'b'=>$q,'code' => $idbadge,'idba'=>$idbad,'user'=>$user
        ]);
    }
    #[Route('/badge/pdf/{idba}', name: 'app_badge_pdf')]
    public function certifPdf(BadgeRepository $rep, Request $request,$idba,Security $security): Response
    {    
        $user = $security->getUser();

        // Récupérer les données nécessaires
        $badge = $rep->find($idba);
        // Créer une nouvelle instance de Fpdi
        $pdf = new Fpdi();
        // Ajouter une page
        $pdf->AddPage();

        // Définir la police
        $pdf->SetFont('Arial', 'B', 16);

        // Ajouter du contenu
        $pdf->Cell(40, 10, 'Badge Information');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 10, 'Badge ID: ' . $badge->getIdba());
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Code: ' . $badge->getCode());
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Name: ' . $badge->getCode());
        $pdf->Ln();

        // Ajouter une image (si disponible)
        $imagePath = $this->getParameter('kernel.project_dir') . '/public/images/logo.png';
        if (file_exists($imagePath)) {
            $pdf->Image($imagePath, 10, 60, 50);
        }

        // Générer le PDF en mémoire
        $pdfOutput = $pdf->Output('S');
        $html = $this->renderView('badge/badge.html.twig', [
            'b' => $badge,'user'=>$user,
        ]);
        // Retourner le PDF en tant que réponse
        $response = new Response($pdfOutput);

        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="badge.pdf"');

        return $response;
    }

        // Récupérer le contenu HTML depuis Twig
      

        // Charger le contenu HTML dans le PDF
      

    #[Route('/badge/create', name: 'app_badge_create')]
    public function create(Request $req,Security $security,EntityManagerInterface $em,BadgeRepository $rep,DepartementRepository $dr,VisiteRepository $vr,VisiteurRepository $vi,EtatBadgeRepository $eb ): Response
    {
        $etat = $eb->find(2); 
    $user = $security->getUser();
    $badge = new Badge();
    $badge->setIdetat($etat);
        $form = $this->createForm(BadgeType::class,$badge); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
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
    $badges = $rep->createQueryBuilder('q')
        ->select('COUNT(q.idba)')
        ->getQuery()
        ->getSingleScalarResult(); 
        if (!($user)) {
            return $this->redirectToRoute('app_404');
        }
        
            if ($form->isSubmitted() && $form->isValid()) { //kn form valide 
                $em = $this->getDoctrine()->getManager(); //nakhedh entity manager eli ta3ml persist l'entite f bd
                $em->persist($badge); //T3awedh persist l'entité Reclamation fil entity manager.
                $em->flush(); //na3ml refresh f bd
                return $this->redirectToRoute('app_badge_create');
            }
        
            return $this->render('badge/index.html.twig', [
                'form' => $form->createView() , 'badgess'=>$r,
                'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges,'user'=>$user
            ]);
    }
    #[Route('/badge/afficher', name: 'app_afficherbadge')]
public function affiche(TypeVisiteurRepository $re,DepartementRepository $dr,VisiteurRepository $rr,EtatBadgeRepository $rep,PersonneVisiteRepository $pv,VisiteRepository $vr,BadgeRepository $br,Security $security,EntityManagerInterface $em){
    $typeVisiteurs = $re->findAll();
    $visiteur = $rr->findAll();
    $etats = $rep->findAll();
    $departement = $dr->findAll();
    $personnesVisite = $pv->findAll();
    $visite = $vr->findAll();
    $badg = $br->findAll();
    $user = $security->getUser();
    $currentDate = new \DateTime();
    $Visiteurs = $rr->createQueryBuilder('q')
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
        if (!($user)) {
    foreach ($badg as $badge) {
        if ($badge->getDatexpiration() > $currentDate) {
            $etat1 = $rep->find(1); // Récupérer l'état avec l'id 1
            $badge->setIdetat($etat1);
        } else {
            $etat2 = $rep->find(2); // Récupérer l'état avec l'id 2
            $badge->setIdetat($etat2);
            $em->persist($badge); // Persist les changements
            $em->flush(); // Flush pour enregistrer les modifications dans la base de données
        }
    }
}
    return $this->render('typev/datatable.html.twig', [
        'typevisis' => $typeVisiteurs,
        'visis' => $visiteur,
        'etats' => $etats,
        'departementss' => $departement,
        'pvs' => $personnesVisite,
        'viss' => $visite,
        'badgess' => $badg,
        'user' => $user,                'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges,'user'=>$user,

    ]);
}
    #[Route('/badge/supprimer/{id}', name: 'app_supprimerbadge')]
    public function supprimer($id,BadgeRepository $re ){
        $r = $re->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($r);
        $em->flush();
        return $this->redirectToRoute('app_afficherbadge');
    }    
    #[Route('/badge/modifier/{id}', name: 'app_modifierbadge')]
    public function modifier(Request $req,$id,Security $security ,badgeRepository $rep,Security $user,DepartementRepository $dr,VisiteRepository $vr,VisiteurRepository $vi,EtatBadgeRepository $eb){
        $user = $security->getUser();

        $p = $rep->find($id); //n3ml instance 
            $form = $this->createForm(BadgeeType::class, $p); //n3ml formulaire  b reclamationtyoe eli fiha champs ta3 entity
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
        $badges = $rep->createQueryBuilder('q')
            ->select('COUNT(q.idba)')
            ->getQuery()
            ->getSingleScalarResult(); 
           
            if ($form->isSubmitted() && $form->isValid()) { //kn form valide 
                $em = $this->getDoctrine()->getManager(); //nakhedh entity manager eli ta3ml persist l'entite f bd
                $em->flush(); //na3ml refresh f bd
        
                return $this->redirectToRoute('app_afficherbadge');
            }
            return $this->render('badge/index.html.twig', [
                'form' => $form->createView() ,'badgess' => $rep->findAll()    , 'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges,'user'=>$user

        ]);
    }
    #[Route('/404', name: 'app_404')]
    public function erre(): Response
    {
        return $this->render('503.html.twig', [
            'controller_name' => 'BadgeController',
        ]);
    }
    #[Route('/calendar', name: 'app_calendar')]
    public function cal(BadgeRepository $rep,Security $security,DepartementRepository $dr,VisiteRepository $vr,VisiteurRepository $vi): Response
    {
        $user=$security->getUser();
        $vis=$vr->findAll();
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
    $badges = $rep->createQueryBuilder('q')
        ->select('COUNT(q.idba)')
        ->getQuery()
        ->getSingleScalarResult(); 
        return $this->render('calendar.html.twig', [
            'controller_name' => 'BadgeController',
                'visiteurs' => $Visiteurs,'visites'=>$Visites,'departements'=>$departements,'badges'=>$badges,'vis'=>$vis,'user'=>$user
        ]);
    }
}
