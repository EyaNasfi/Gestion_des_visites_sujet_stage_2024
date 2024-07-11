<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Departement
 *
 * @ORM\Table(name="departement")
 * @ORM\Entity
 */
class Departement
{
    /**
     * @var int
     *
     * @ORM\Column(name="iddep", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iddep;

    /**
     * @var string
     *
     * @ORM\Column(name="nomdep", type="string", length=255, nullable=false)
     */
    private $nomdep;

    public function __tostring()
    {
        return $this->nomdep;
    }

    /**
     * Get the value of nomdep
     *
     * @return  string
     */ 
    public function getNomdep()
    {
        return $this->nomdep;
    }

    /**
     * Set the value of nomdep
     *
     * @param  string  $nomdep
     *
     * @return  self
     */ 
    public function setNomdep(string $nomdep)
    {
        $this->nomdep = $nomdep;

        return $this;
    }

    /**
     * Get the value of iddep
     *
     * @return  int
     */ 
    public function getIddep()
    {
        return $this->iddep;
    }

    /**
     * Set the value of iddep
     *
     * @param  int  $iddep
     *
     * @return  self
     */ 
    public function setIddep(int $iddep)
    {
        $this->iddep = $iddep;

        return $this;
    }
}
