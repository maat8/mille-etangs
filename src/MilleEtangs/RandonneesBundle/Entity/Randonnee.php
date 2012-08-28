<?php

namespace MilleEtangs\RandonneesBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="randonnees")
 */
class Randonnee
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\NotBlank
	 */
	protected $slug;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\NotBlank
	 */
	protected $name;

	/**
	 * @ORM\Column(type="text")
	 * @Assert\NotBlank
	 */
	protected $description;

	/**
	 * @ORM\Column(type="string", length=512)
	 */
	protected $endomondo_link;

	/**
     * @ORM\Column(type="integer")
	 * @Assert\Min(0)
	 */
	protected $duree_vtt;


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
     * Set slug
     *
     * @param string $slug
     * @return Randonnee
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
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
     * Set name
     *
     * @param string $name
     * @return Randonnee
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
     * @return Randonnee
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
     * @return Randonnee
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
     * @return Randonnee
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
}