<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeVisiteur
 *
 * @ORM\Table(name="type_visiteur")
 * @ORM\Entity
 */
class TypeVisiteur
{
    /**
     * @var int
     *
     * @ORM\Column(name="idtype", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtype;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=255, nullable=false)
     */
    private $contenu;
    public function __tostring()
    {
        return $this->getContenu();
    }


    /**
     * Get the value of contenu
     *
     * @return  string
     */ 
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set the value of contenu
     *
     * @param  string  $contenu
     *
     * @return  self
     */ 
    public function setContenu(string $contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get the value of idtype
     *
     * @return  int
     */ 
    public function getIdtype()
    {
        return $this->idtype;
    }

    /**
     * Set the value of idtype
     *
     * @param  int  $idtype
     *
     * @return  self
     */ 
    public function setIdtype(int $idtype)
    {
        $this->idtype = $idtype;

        return $this;
    }
}
