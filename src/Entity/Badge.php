<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
/**
 * Badge
 *
 * @ORM\Table(name="badge", uniqueConstraints={@ORM\UniqueConstraint(name="code", columns={"code"})}, indexes={@ORM\Index(name="idfk2", columns={"idetat"})})
 * @ORM\Entity
 * @UniqueEntity(fields="code", message="Ce code est déjà utilisé.")

 */
class Badge
{
    /**
     * @var int
     *
     * @ORM\Column(name="idba", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idba;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=false)
     * @Assert\NotBlank( message="Entrez le code badge svp")
     */
    private $code;

    /**
     * @var \DateTime
     *
 * @ORM\Column(name="datecreation", type="date", nullable=false)
  */

    private $datecreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datexpiration", type="date", nullable=false)
     * @Assert\GreaterThanOrEqual("today", message="La date dexpiration doit être une date  future.")

     */
    private $datexpiration;

    /**
     * @var \EtatBadge
     *
     * @ORM\ManyToOne(targetEntity="EtatBadge")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idetat", referencedColumnName="idetat")
     * })
     */
    private $idetat;


        /**
     * @Assert\Callback
     */
    public function validateHeureDepartSupHeureArrivee(ExecutionContextInterface $context)
    {
        if ($this->getDatecreation() >= $this->getDatexpiration()) {
            $context->buildViolation('La date d/expiration doit être après la date de creation ')
                ->atPath('datecreation')
                ->addViolation();
        }
    }

    /**
     * Get the value of idba
     *
     * @return  int
     */ 
    public function getIdba()
    {
        return $this->idba;
    }

    /**
     * Set the value of idba
     *
     * @param  int  $idba
     *
     * @return  self
     */ 
    public function setIdba(int $idba)
    {
        $this->idba = $idba;

        return $this;
    }

    /**
     * Get the value of idetat
     *
     * @return  \EtatBadge
     */ 
    public function getIdetat():?EtatBadge
    {
        return $this->idetat;
    }

    /**
     * Set the value of idetat
     *
     * @param  \EtatBadge  $idetat
     *
     * @return  self
     */ 
    public function setIdetat(?EtatBadge $idetat)
    {
        $this->idetat = $idetat;

        return $this;
    }

    /**
     * Get the value of datexpiration
     *
     * @return  \DateTime
     */ 
    public function getDatexpiration()
    {
        return $this->datexpiration;
    }

    /**
     * Set the value of datexpiration
     *
     * @param  \DateTime  $datexpiration
     *
     * @return  self
     */ 
    public function setDatexpiration(\DateTime $datexpiration)
    {
        $this->datexpiration = $datexpiration;

        return $this;
    }

    /**
     * Get the value of datecreation
     *
     * @return  \DateTime
     */ 
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * Set the value of datecreation
     *
     * @param  \DateTime  $datecreation
     *
     * @return  self
     */ 
    public function setDatecreation(\DateTime $datecreation)
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get the value of code
     *
     * @return  string
     */ 
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @param  string  $code
     *
     * @return  self
     */ 
    public function setCode(string $code)
    {
        $this->code = $code;

        return $this;
    }
    public function __tostring()
{
    return $this->code;
}
}