<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Visiteur
 *
 * @ORM\Table(name="visiteur", uniqueConstraints={@ORM\UniqueConstraint(name="ciun", columns={"cin"})}, indexes={@ORM\Index(name="idfk", columns={"idtype"})})
 * @ORM\Entity
 * @UniqueEntity(fields="cin", message="Ce CIN est déjà utilisé.")
 */
class Visiteur
{
    /**
     * @var int
     *
     * @ORM\Column(name="idv", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idv;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=11, nullable=false)
     * @Assert\NotBlank( message="Entrez le nom svp")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=11, nullable=false)
     * @Assert\NotBlank( message="Entrez le prenom svp")

     */
    private $prenom;

    /**
     * @var int
     *
     * @ORM\Column(name="num_tlf", type="integer", nullable=false)
     * @Assert\NotBlank( message="Entrez le numero de telephone svp")

     */
    private $numTlf;

    /**
     * @var int
     *
     * @ORM\Column(name="cin", type="integer", nullable=false)
     * @Assert\NotBlank( message="Entrez le cin svp")
     */
    private $cin;

    /**
     * @var \TypeVisiteur
     *
     * @ORM\ManyToOne(targetEntity="TypeVisiteur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idtype", referencedColumnName="idtype")
     * })
     * @Assert\NotBlank( message="Entrez le type de visiteur svp")

     */
    private $idtype;
    public function __tostring()
    {
        return $this->getNom();
    }


    /**
     * Get the value of idv
     *
     * @return  int
     */ 
    public function getIdv()
    {
        return $this->idv;
    }

    /**
     * Set the value of idv
     *
     * @param  int  $idv
     *
     * @return  self
     */ 
    public function setIdv(int $idv)
    {
        $this->idv = $idv;

        return $this;
    }

    /**
     * Get the value of cin
     *
     * @return  int
     */ 
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set the value of cin
     *
     * @param  int  $cin
     *
     * @return  self
     */ 
    public function setCin(int $cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get the value of numTlf
     *
     * @return  int
     */ 
    public function getNumTlf()
    {
        return $this->numTlf;
    }

    /**
     * Set the value of numTlf
     *
     * @param  int  $numTlf
     *
     * @return  self
     */ 
    public function setNumTlf(int $numTlf)
    {
        $this->numTlf = $numTlf;

        return $this;
    }

    /**
     * Get the value of prenom
     *
     * @return  string
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @param  string  $prenom
     *
     * @return  self
     */ 
    public function setPrenom(string $prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of nom
     *
     * @return  string
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @param  string  $nom
     *
     * @return  self
     */ 
    public function setNom(string $nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of idtype
     *
     * @return  \TypeVisiteur
     */ 
    public function getIdtype():?TypeVisiteur
    {
        return $this->idtype;
    }

    /**
     * Set the value of idtype
     *
     * @param  \TypeVisiteur  $idtype
     *
     * @return  self
     */ 
    public function setIdtype(?TypeVisiteur $idtype)
    {
        $this->idtype = $idtype;

        return $this;
    }
}
