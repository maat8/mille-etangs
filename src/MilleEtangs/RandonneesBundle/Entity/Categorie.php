<?php

namespace MilleEtangs\RandonneesBundle\Entity;

use Symfony\Component\Validator\Constraint as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="categories")
 */
class Categorie extends EntityBase
{

	/**
     * @ORM\OneToMany(targetEntity="Actualite", mappedBy="categorie")
     */
	protected $actualites;

	public function __construct()
    {
        $this->actualites = new ArrayCollection();
    }

    /**
     * Add actualites
     *
     * @param MilleEtangs\RandonneesBundle\Entity\Actualite $actualites
     * @return Categorie
     */
    public function addActualite(\MilleEtangs\RandonneesBundle\Entity\Actualite $actualites)
    {
        $this->actualites[] = $actualites;
    
        return $this;
    }

    /**
     * Remove articles
     *
     * @param MilleEtangs\RandonneesBundle\Entity\Actualite $articles
     */
    public function removeActualite(\MilleEtangs\RandonneesBundle\Entity\Actualite $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Get articles
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getActualites()
    {
        return $this->articles;
    }

    public function __toString()
    {
        return $this->getNom();
    }
}