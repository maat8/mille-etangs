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
}