<?php

namespace MilleEtangs\RandonneesBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use MilleEtangs\RandonneesBundle\Document\Comment;

/**
 * @ODM\Document(collection="itinearies", repositoryClass="MilleEtangs\RandonneesBundle\Repository\ItinearyRepository")
 */
class Itineary extends BaseDocument
{
    /**
     * @ODM\String
     */
    protected $teaser;

    /**
     * @ODM\String
     */
    protected $access;

    /**
     * @ODM\String
     */
    protected $description;

    /**
     * @ODM\Int
     * @Assert\Range(min=0)
     * @ODM\Index
     */
    protected $bikeLength = 0;

    /**
     * @ODM\Int
     * @Assert\Range(min=0)
     * @ODM\Index
     */
    protected $hikeLength = 0;

    /**
     * @ODM\Int
     * @Assert\Range(min=0)
     */
    protected $distance = 0;

    /**
     * @ODM\Int
     * @Assert\Range(min=0)
     */
    protected $incline = 0;

    /**
     * @ODM\String
     */
    protected $endomondoLink;

    /**
     * Cannot embed document having q GridFS file : https://github.com/doctrine/mongodb-odm/issues/911
     * @ODM\ReferenceOne(targetDocument="Trace", simple=true, orphanRemoval=true, cascade={"all"})
     */
    protected $gpx;

    /**
     * @ODM\ReferenceOne(targetDocument="Trace", simple=true, orphanRemoval=true, cascade={"all"})
     */
    protected $kml;

    /**
     * @ODM\Boolean
    */
    protected $marked;

    /**
     * @ODM\Int
     * @Assert\Range(min=1, max=3)
     */
    protected $difficulty;

    /**
     * @ODM\Boolean
    */
    protected $published;

    /**
     * @ODM\EmbedOne(targetDocument="Point")
     */
    protected $start;

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
     * Set endomondoLink
     *
     * @param string $endomondoLink
     * @return Itineary
     */
    public function setEndomondoLink($endomondoLink)
    {
        $this->endomondoLink = $endomondoLink;

        return $this;
    }

    /**
     * Get endomondoLink
     *
     * @return string
     */
    public function getEndomondoLink()
    {
        return $this->endomondoLink;
    }

    /**
     * Set bikeLength
     *
     * @param integer $bikeLength
     * @return Itineary
     */
    public function setBikeLength($bikeLength)
    {
        $this->bikeLength = $bikeLength;

        return $this;
    }

    /**
     * Get bikeLength
     *
     * @return integer
     */
    public function getBikeLength()
    {
        return $this->bikeLength;
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
     * Set hikeLength
     *
     * @param integer $hikeLength
     * @return Itineary
     */
    public function setHikeLength($hikeLength)
    {
        $this->hikeLength = $hikeLength;

        return $this;
    }

    /**
     * Get hikeLength
     *
     * @return integer
     */
    public function getHikeLength()
    {
        return $this->hikeLength;
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

    /**
     * Set marked
     *
     * @param integer $marked
     * @return Itineary
     */
    public function setMarked($marked)
    {
        $this->marked = $marked;

        return $this;
    }

    /**
     * Get marked
     *
     * @return integer
     */
    public function getMarked()
    {
        return $this->marked;
    }

    /**
     * Set difficulty
     *
     * @param integer $difficulty
     * @return Itineary
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * Get difficulty
     *
     * @return integer
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Set gpx
     *
     * @param Trace $gpx
     * @return self
     */
    public function setGpx($gpx)
    {
        $this->gpx = $gpx;
        return $this;
    }

    /**
     * Get gpx
     *
     * @return Trace $gpx
     */
    public function getGpx()
    {
        return $this->gpx;
    }

    /**
     * Set kml
     *
     * @param Trace $kml
     * @return self
     */
    public function setKml($kml)
    {
        $this->kml = $kml;
        return $this;
    }

    /**
     * Get kml
     *
     * @return Trace $kml
     */
    public function getKml()
    {
        return $this->kml;
    }
}
