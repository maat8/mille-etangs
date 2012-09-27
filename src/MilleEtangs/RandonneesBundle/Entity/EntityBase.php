<?php

namespace MilleEtangs\RandonneesBundle\Entity;

use Symfony\Component\Validator\Constraint as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
class EntityBase
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
    protected $nom;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $slug;

	/**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated;

	protected function generateSlug($string)
    {
        $string = html_entity_decode(preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde|cedil|ring);/', '$1', htmlentities($string)));
        $string = strtolower($string);
        $string = trim(preg_replace('/[^0-9a-zA-Z]+/', '-', $string));

        return $string;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        if(is_null($this->created))        
            $this->created = new \DateTime();
        $this->updated = new \DateTime();
        $this->slug = $this->generateSlug($this->nom);
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
     * Set created
     *
     * @param \DateTime $created
     * @return Actualite
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
     * @return Actualite
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