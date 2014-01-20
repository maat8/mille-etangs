<?php

namespace MilleEtangs\RandonneesBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/** 
 * @ODM\Document(collection="itinearies", repositoryClass="MilleEtangs\RandonneesBundle\Repository\ItinearyRepository")
 */
class Itineary extends BaseDocument
{
    /**
     * @ODM\Field(type="string")
     */
    protected $teaser;

    /**
     * @ODM\Field(type="string")
     */
    protected $access;

    /**
     * @ODM\Field(type="string")
     */
    protected $description;

    /**
     * @ODM\Field(type="int")
     * @Assert\Min(0)
     */
    protected $bike_length = 0;

    /**
     * @ODM\Field(type="int")
     * @Assert\Min(0)
     */
    protected $hike_length = 0;

    /**
     * @ODM\Field(type="int")
     * @Assert\Min(0)
     */
    protected $distance = 0;

    /**
     * @ODM\Field(type="int")
     * @Assert\Min(0)
     */
    protected $incline = 0;

    /**
     * @ODM\Field(type="string")
     */
    protected $endomondo_link;

    /** 
     * @ODM\Field(type="boolean")
    */
    protected $published;

    /**
     * Set description
     *
     * @param string $description
     * @return Itineary
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
     * @return Itineary
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
     * Set bike_length
     *
     * @param integer $bikeLength
     * @return Itineary
     */
    public function setBikeLength($bikeLength)
    {
        $this->bike_length = $bikeLength;
    
        return $this;
    }

    /**
     * Get bike_length
     *
     * @return integer 
     */
    public function getBikeLength()
    {
        return $this->bike_length;
    }

    /**
     * Set distance
     *
     * @param integer $distance
     * @return Itineary
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
     * Set incline
     *
     * @param integer $incline
     * @return Itineary
     */
    public function setIncline($incline)
    {
        $this->incline = $incline;
    
        return $this;
    }

    /**
     * Get incline
     *
     * @return integer 
     */
    public function getIncline()
    {
        return $this->incline;
    }

    /**
     * Set teaser
     *
     * @param string $teaser
     * @return Itineary
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
     * @return Itineary
     */
    public function setAccess($access)
    {
        $this->access = $access;
    
        return $this;
    }

    /**
     * Get acces
     *
     * @return string 
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * Set hike_length
     *
     * @param integer $hikeLength
     * @return Itineary
     */
    public function setHikeLength($hikeLength)
    {
        $this->hike_length = $hikeLength;
    
        return $this;
    }

    /**
     * Get hike_length
     *
     * @return integer 
     */
    public function getHikeLength()
    {
        return $this->hike_length;
    }

    /**
     * Set published
     *
     * @param integer $published
     * @return Itineary
     */
    public function setPublished($published)
    {
        $this->published = $published;
    
        return $this;
    }

    /**
     * Get published
     *
     * @return integer 
     */
    public function getPublished()
    {
        return $this->published;
    }
}
