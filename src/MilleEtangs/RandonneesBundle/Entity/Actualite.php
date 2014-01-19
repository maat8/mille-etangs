<?php

namespace MilleEtangs\RandonneesBundle\Entity;

use Symfony\Component\Validator\Constraint as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="MilleEtangs\RandonneesBundle\Repository\ActualiteRepository")
 * @ORM\Table(name="actualites")
 * @ORM\HasLifecycleCallbacks
 */
class Actualite extends EntityBase
{
	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $message;

	/**	
	 * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="actualites")
	 * @ORM\JoinColumn(name="categorie_id", referencedColumnName="id")
	*/
	protected $categorie;

    /** 
     * @ORM\Column(type="date")
    */
    protected $publication;

    public function __construct()
    {
        $this->publication = new \DateTime();
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Actualite
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set categorie
     *
     * @param MilleEtangs\RandonneesBundle\Entity\Categorie $categorie
     * @return Actualite
     */
    public function setCategorie(\MilleEtangs\RandonneesBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;
    
        return $this;
    }

    /**
     * Get categorie
     *
     * @return MilleEtangs\RandonneesBundle\Entity\Categorie 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set publication
     *
     * @param \Date $publication
     * @return Actualite
     */
    public function setPublication($publication = null)
    {
        $this->publication = $publication;
    
        return $this;
    }

    /**
     * Get publication
     *
     * @return \Date
     */
    public function getPublication()
    {
        return $this->publication;
    }
}