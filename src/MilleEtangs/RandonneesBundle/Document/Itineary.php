<?php

namespace MilleEtangs\RandonneesBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Symm\Gisconverter\Gisconverter as Gisconverter;
use Doctrine\MongoDB\GridFSFile;
use MilleEtangs\RandonneesBundle\Document\Comment;
use MilleEtangs\RandonneesBundle\Document\Trace;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    public function generateKmlFromGpx()
    {
        if (is_object($this->gpx)) {
            try {
                $kml = Gisconverter::gpxToKml($this->gpx->getFile()->getBytes());
                if (!empty($kml)) {
                    // TODO : generate KML using simplexml
                    $kml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" .
                                '<kml xmlns="http://www.opengis.net/kml/2.2">
                                    <Document>
                                    <name></name>
                                    <description>c</description>
                                    <Style id="blueLine">
                                      <LineStyle>
                                        <color>ffff0000</color>
                                        <width>4</width>
                                      </LineStyle>
                                    </Style>
                                    <Style id="redLine">
                                      <LineStyle>
                                        <color>ff0000ff</color>
                                        <width>4</width>
                                      </LineStyle>
                                    </Style>
                                    <Style id="greenLine">
                                      <LineStyle>
                                        <color>ff009900</color>
                                        <width>4</width>
                                      </LineStyle>
                                    </Style>
                                    <Style id="orangeLine">
                                      <LineStyle>
                                        <color>ff00ccff</color>
                                        <width>4</width>
                                      </LineStyle>
                                    </Style>
                                    <Style id="pinkLine">
                                      <LineStyle>
                                        <color>ffff33ff</color>
                                        <width>4</width>
                                      </LineStyle>
                                    </Style>
                                    <Style id="brownLine">
                                      <LineStyle>
                                        <color>ff66a1cc</color>
                                        <width>4</width>
                                      </LineStyle>
                                    </Style>
                                    <Style id="purpleLine">
                                      <LineStyle>
                                        <color>ffcc00cc</color>
                                        <width>4</width>
                                      </LineStyle>
                                    </Style>
                                    <Style id="yellowLine">
                                      <LineStyle>
                                        <color>ff61f2f2</color>
                                        <width>4</width>
                                      </LineStyle>
                                    </Style>
                                    <Placemark>
                                        <name>Name</name>
                                        <description>Description</description>
                                        <styleUrl>#blueLine</styleUrl>' .
                                $kml .
                                '   </Placemark>
                                </Document>
                                </kml>';

                    $trace_kml = new Trace();
                    $kml_file = new GridFSFile();
                    $kml_file->setBytes($kml);
                    $trace_kml->setFile($kml_file);
                    $this->setKml($trace_kml);
                }
            } catch (\Exception $e) {

            }
        }
    }

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
