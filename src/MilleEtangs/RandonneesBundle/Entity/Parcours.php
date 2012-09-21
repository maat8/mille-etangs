<?php

namespace MilleEtangs\RandonneesBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="MilleEtangs\RandonneesBundle\Repository\ParcoursRepository")
 * @ORM\Table(name="parcours")
 * @ORM\HasLifecycleCallbacks
 */
class Parcours extends EntityBase
{

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	protected $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $teaser;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $acces;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $description;

	/**
     * @ORM\Column(type="integer")
	 * @Assert\Min(0)
	 */
	protected $duree_vtt = 0;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Min(0)
     */
    protected $duree_cheval = 0;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Min(0)
     */
    protected $duree_marche = 0;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Min(0)
     */
    protected $distance = 0;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Min(0)
     */
    protected $denivele_positif = 0;

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     */
    protected $endomondo_link;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Parcours
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Parcours
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Parcours
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set endomondo_link
     *
     * @param string $endomondoLink
     * @return Parcours
     */
    public function setEndomondoLink($endomondoLink)
    {
        $this->endomondo_link = $endomondoLink;
    
        return $this;
    }

    /**
     * Get endomondo_link
     *
     * @return string 
     */
    public function getEndomondoLink()
    {
        return $this->endomondo_link;
    }

    /**
     * Set duree_vtt
     *
     * @param integer $dureeVtt
     * @return Parcours
     */
    public function setDureeVtt($dureeVtt)
    {
        $this->duree_vtt = $dureeVtt;
    
        return $this;
    }

    /**
     * Get duree_vtt
     *
     * @return integer 
     */
    public function getDureeVtt()
    {
        return $this->duree_vtt;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Parcours
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set distance
     *
     * @param integer $distance
     * @return Parcours
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    
        return $this;
    }

    /**
     * Get distance
     *
     * @return integer 
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set denivele_positif
     *
     * @param integer $denivelePositif
     * @return Parcours
     */
    public function setDenivelePositif($denivelePositif)
    {
        $this->denivele_positif = $denivelePositif;
    
        return $this;
    }

    /**
     * Get denivele_positif
     *
     * @return integer 
     */
    public function getDenivelePositif()
    {
        return $this->denivele_positif;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Parcours
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Parcours
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set teaser
     *
     * @param string $teaser
     * @return Parcours
     */
    public function setTeaser($teaser)
    {
        $this->teaser = $teaser;
    
        return $this;
    }

    /**
     * Get teaser
     *
     * @return string 
     */
    public function getTeaser()
    {
        return $this->teaser;
    }

    /**
     * Set acces
     *
     * @param string $acces
     * @return Parcours
     */
    public function setAcces($acces)
    {
        $this->acces = $acces;
    
        return $this;
    }

    /**
     * Get acces
     *
     * @return string 
     */
    public function getAcces()
    {
        return $this->acces;
    }

    /**
     * Set duree_cheval
     *
     * @param integer $dureeCheval
     * @return Parcours
     */
    public function setDureeCheval($dureeCheval)
    {
        $this->duree_cheval = $dureeCheval;
    
        return $this;
    }

    /**
     * Get duree_cheval
     *
     * @return integer 
     */
    public function getDureeCheval()
    {
        return $this->duree_cheval;
    }

    /**
     * Set duree_marche
     *
     * @param integer $dureeMarche
     * @return Parcours
     */
    public function setDureeMarche($dureeMarche)
    {
        $this->duree_marche = $dureeMarche;
    
        return $this;
    }

    /**
     * Get duree_marche
     *
     * @return integer 
     */
    public function getDureeMarche()
    {
        return $this->duree_marche;
    }
}