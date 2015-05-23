<?php

namespace MilleEtangs\RandonneesBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(collection="events")
 */
class Event extends Place
{
    /**
     * @ODM\Field(type="date")
     */
    protected $date;
}
