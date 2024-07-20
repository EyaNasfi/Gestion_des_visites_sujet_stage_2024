<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Visite
 *
 * @ORM\Table(name="visite", indexes={@ORM\Index(name="idemployeevisit", columns={"idemployeevisit"}), @ORM\Index(name="idbadge", columns={"idbadge"}), @ORM\Index(name="idv", columns={"idv"})})
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
     */
    private $datevisite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure_arrivee", type="datetime", nullable=false)
     */
    private $heureArrivee;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="heure_depart", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $heureDepart;

    /**
     * @var string
     *
     * @ORM\Column(name="But", type="text", length=65535, nullable=false)
     */
    private $but;

    /**
     * @var \Badge
     *
     * @ORM\ManyToOne(targetEntity="Badge")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idbadge", referencedColumnName="idba")
     * })
     */
    private $idbadge;

    /**
     * @var \Visiteur
     *
     * @ORM\ManyToOne(targetEntity="Visiteur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idv", referencedColumnName="idv")
     * })
     */
    private $idv;

    /**
     * @var \PersonneVisite
     *
     * @ORM\ManyToOne(targetEntity="PersonneVisite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idemployeevisit", referencedColumnName="matricule")
     * })
     */
    private $idemployeevisit;



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
     * Get the value of idemployeevisit
     *
     * @return  \PersonneVisite
     */ 
    public function getIdemployeevisit()
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
    public function getIdv()
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
     * Get the value of idbadge
     *
     * @return  \Badge
     */ 
    public function getIdbadge()
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
     * Get the value of heureDepart
     *
     * @return  \DateTime|null
     */ 
    public function getHeureDepart()
    {
        return $this->heureDepart;
    }

    /**
     * Set the value of heureDepart
     *
     * @param  \DateTime|null  $heureDepart
     *
     * @return  self
     */ 
    public function setHeureDepart($heureDepart)
    {
        $this->heureDepart = $heureDepart;

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

    /**
     * Set the value of datevisite
     *
     * @param  \DateTime  $datevisite
     *
     * @return  self
     */ 
    public function setDatevisite(\DateTime $datevisite)
    {
        $this->datevisite = $datevisite;

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
}
