<?php

namespace MilleEtangs\RandonneesBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ODM\MappedSuperclass
 * @ODM\HasLifecycleCallbacks
 */
abstract class BaseDocument
{
    /**
     * @ODM\Id
     */
    protected $id;

    /**
     * @ODM\Field(type="string")
     */
    protected $name;

    /**
     * @ODM\Field(type="string")
     */
    protected $slug;

    /**
     * @ODM\Field(type="timestamp")
     */
    protected $created;

    /**
     * @ODM\Field(type="timestamp")
     */
    protected $updated;

    /**
     * @ODM\PrePersist()
     * @ODM\PreUpdate()
     */
    public function preUpdate()
    {
        if (is_null($this->created)) {
            $this->created = time();
        }
        $this->updated = time();
        $this->slug = $this->generateSlug($this->name);
    }

    protected function generateSlug($string)
    {
        $string = html_entity_decode(
            preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde|cedil|ring);/', '$1', htmlentities($string))
        );
        $string = strtolower($string);
        $string = trim(preg_replace('/[^0-9a-zA-Z]+/', '-', $string));

        return $string;
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
     * Set id
     *
     * @param integer $id
     * @return Entity
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Entity
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
     * @return Entity
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
