<?php

namespace MilleEtangs\RandonneesBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="parcours")
 */
class Parcours
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	protected $slug;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $nom;

	/**
	 * @ORM\Column(type="text")
	 * @Assert\NotBlank
	 */
	protected $description;

	/**
	 * @ORM\Column(type="string", length=512, nullable=true)
	 */
	protected $endomondo_link;

	/**
     * @ORM\Column(type="integer")
	 * @Assert\Min(0)
	 */
	protected $duree_vtt;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Min(0)
     */
    protected $distance;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\Min(0)
     */
    protected $denivele_positif;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated;

    /**
     * @ORM\PrePersist
     */
    public function setUpdatededValue()
    {
        $this->updated = new \DateTime();
    }

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
}