<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtatBadge
 *
 * @ORM\Table(name="etat_badge")
 * @ORM\Entity
 */
class EtatBadge
{
    /**
     * @var int
     *
     * @ORM\Column(name="idetat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idetat;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=11, nullable=false)
     */
    private $libelle;

    public function __tostring()
    {
        return $this->libelle;
    }

    /**
     * Get the value of idetat
     *
     * @return  int
     */ 
    public function getIdetat()
    {
        return $this->idetat;
    }

    /**
     * Set the value of idetat
     *
     * @param  int  $idetat
     *
     * @return  self
     */ 
    public function setIdetat(int $idetat)
    {
        $this->idetat = $idetat;

        return $this;
    }

    /**
     * Get the value of libelle
     *
     * @return  string
     */ 
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set the value of libelle
     *
     * @param  string  $libelle
     *
     * @return  self
     */ 
    public function setLibelle(string $libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }
}
