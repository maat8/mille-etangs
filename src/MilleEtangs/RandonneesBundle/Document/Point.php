<?php

namespace MilleEtangs\RandonneesBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** 
 * @ODM\EmbeddedDocument
 */
class Point
{
    /** @ODM\Float */
    protected $latitude;

    /** @ODM\Float */
    protected $longitude;

    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}
