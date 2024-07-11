<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * PersonneVisite
 *
 * @ORM\Table(name="personne_visite", indexes={@ORM\Index(name="idfk", columns={"iddep"})})
 * @ORM\Entity
 */
class PersonneVisite
{
    /**
     * @var int
     *
     * @ORM\Column(name="matricule", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $matricule;

    /**
     * @var string
     *
     * @ORM\Column(name="nomprenom", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="le nom et prenom ne peut pas etre vide")

     */
    private $nomprenom;

    /**
     * @var string
     *
     * @ORM\Column(name="metier", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="le metier ne peut pas etre vide")
     */
    private $metier;

    /**
     * @var \Departement
     *
     * @ORM\ManyToOne(targetEntity="Departement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iddep", referencedColumnName="iddep")
     * })
     * @Assert\NotBlank( message="Entrez le nom de departement svp")
     */
    private $iddep;

    public function __tostring()
    {
        return $this->nomprenom;
    }

    /**
     * Get the value of iddep
     *
     * @return  \Departement
     */ 
    public function getIddep():?Departement
    {
        return $this->iddep;
    }

    /**
     * Set the value of iddep
     *
     * @param  \Departement  $iddep
     *
     * @return  self
     */ 
    public function setIddep(?Departement $iddep)
    {
        $this->iddep = $iddep;

        return $this;
    }

    /**
     * Get the value of metier
     *
     * @return  string
     */ 
    public function getMetier()
    {
        return $this->metier;
    }

    /**
     * Set the value of metier
     *
     * @param  string  $metier
     *
     * @return  self
     */ 
    public function setMetier(string $metier)
    {
        $this->metier = $metier;

        return $this;
    }

    /**
     * Get the value of nomprenom
     *
     * @return  string
     */ 
    public function getNomprenom()
    {
        return $this->nomprenom;
    }

    /**
     * Set the value of nomprenom
     *
     * @param  string  $nomprenom
     *
     * @return  self
     */ 
    public function setNomprenom(string $nomprenom)
    {
        $this->nomprenom = $nomprenom;

        return $this;
    }

    /**
     * Get the value of matricule
     *
     * @return  int
     */ 
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set the value of matricule
     *
     * @param  int  $matricule
     *
     * @return  self
     */ 
    public function setMatricule(int $matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }
}
