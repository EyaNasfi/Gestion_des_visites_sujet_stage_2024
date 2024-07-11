<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Visite
 *
 * @ORM\Table(name="visite", indexes={@ORM\Index(name="idbadge", columns={"idbadge"}), @ORM\Index(name="idv", columns={"idv"}), @ORM\Index(name="idemployeevisit", columns={"idemployeevisit"})})
 * @ORM\Entity
 */
class Visite
{
    /**
     * @var int
     *
     * @ORM\Column(name="idvisite", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idvisite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datevisite", type="date", nullable=false)
     * @Assert\GreaterThanOrEqual("today", message="La date de visite doit être actuelle ou future.")
     */
    private $datevisite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure_arrivee", type="datetime", nullable=false)
     * 
     */
    
    private $heureArrivee;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure_depart", type="datetime", nullable=false)
     * 
     */
    private $heureDepart;

    /**
     * @var string
     *
     * @ORM\Column(name="But", type="text", length=65535, nullable=false)
     * @Assert\NotBlank(message="le but ne peut pas rester vide")
     */
    private $but;

    /**
     * @var \Visiteur
     *
     * @ORM\ManyToOne(targetEntity="Visiteur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idv", referencedColumnName="idv")
     * })
     * @Assert\NotBlank( message="Entrez le nom de visiteur svp")

     */
    private $idv;

    /**
     * @var \PersonneVisite
     *
     * @ORM\ManyToOne(targetEntity="PersonneVisite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idemployeevisit", referencedColumnName="matricule")
     * })
     * @Assert\NotBlank( message="Entrez l'employe  svp")

     */
    private $idemployeevisit;

    /**
     * @var \Badge
     *
     * @ORM\ManyToOne(targetEntity="Badge")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idbadge", referencedColumnName="idba")
     * })
     * @Assert\NotBlank( message="Entrez le code de badge svp")

     */
    private $idbadge;
    public function __tostring()
    {
        return $this->datevisite->format('Y-m-d') . ' ' . $this->heureArrivee->format('H:i') . ' - ' . $this->heureDepart->format('H:i');
}


    /**
     * Get the value of idbadge
     *
     * @return  \Badge
     */ 
    public function getIdbadge():?Badge
    {
        return $this->idbadge;
    }

    /**
     * Set the value of idbadge
     *
     * @param  \Badge  $idbadge
     *
     * @return  self
     */ 
    public function setIdbadge(?Badge $idbadge)
    {
        $this->idbadge = $idbadge;

        return $this;
    }

    /**
     * Get the value of idemployeevisit
     *
     * @return  \PersonneVisite
     */ 
    public function getIdemployeevisit():?PersonneVisite
    {
        return $this->idemployeevisit;
    }

    /**
     * Set the value of idemployeevisit
     *
     * @param  \PersonneVisite  $idemployeevisit
     *
     * @return  self
     */ 
    public function setIdemployeevisit(?PersonneVisite $idemployeevisit)
    {
        $this->idemployeevisit = $idemployeevisit;

        return $this;
    }

    /**
     * Get the value of idv
     *
     * @return  \Visiteur
     */ 
    public function getIdv():?Visiteur
    {
        return $this->idv;
    }

    /**
     * Set the value of idv
     *
     * @param  \Visiteur  $idv
     *
     * @return  self
     */ 
    public function setIdv(?Visiteur $idv)
    {
        $this->idv = $idv;

        return $this;
    }

    /**
     * Get the value of but
     *
     * @return  string
     */ 
    public function getBut()
    {
        return $this->but;
    }

    /**
     * Set the value of but
     *
     * @param  string  $but
     *
     * @return  self
     */ 
    public function setBut(string $but)
    {
        $this->but = $but;

        return $this;
    }

    /**
     * Get the value of idvisite
     *
     * @return  int
     */ 
    public function getIdvisite()
    {
        return $this->idvisite;
    }

    /**
     * Set the value of idvisite
     *
     * @param  int  $idvisite
     *
     * @return  self
     */ 
    public function setIdvisite(int $idvisite)
    {
        $this->idvisite = $idvisite;

        return $this;
    }

    /**
     * Get the value of heureDepart
     *
     * @return  \DateTime
     */ 
    public function getHeureDepart()
    {
        return $this->heureDepart;
    }

    /**
     * Set the value of heureDepart
     *
     * @param  \DateTime  $heureDepart
     *
     * @return  self
     */ 
    public function setHeureDepart(\DateTime $heureDepart)
    {
        $this->heureDepart = $heureDepart;

        return $this;
    }

    /**
     * Get the value of heureArrivee
     *
     * @return  \DateTime
     */ 
    public function getHeureArrivee()
    {
        return $this->heureArrivee;
    }

    /**
     * Set the value of heureArrivee
     *
     * @param  \DateTime  $heureArrivee
     *
     * @return  self
     */ 
    public function setHeureArrivee(\DateTime $heureArrivee)
    {
        $this->heureArrivee = $heureArrivee;

        return $this;
    }

    /**
     * Get the value of datevisite
     *
     * @return  \DateTime
     */ 
    public function getDatevisite()
    {
        return $this->datevisite;
    }

    public function setDatevisite(\DateTime $datevisite): self
    {
        $this->datevisite = $datevisite;

        return $this;
    }
        /**
     * @Assert\Callback
     */
    public function validateHeureDepartSupHeureArrivee(ExecutionContextInterface $context)
    {
        if ($this->heureDepart <= $this->heureArrivee) {
            $context->buildViolation('L\'heure de départ doit être après l\'heure d\'arrivée.')
                ->atPath('heureDepart')
                ->addViolation();
        }
    }

    /**
     * Set the value of datevisite
     *
     * @param  \DateTime  $datevisite
     *
     * @return  self
     */ 
   
}
