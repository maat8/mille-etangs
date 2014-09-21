<?php

namespace MilleEtangs\RandonneesBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

class ItinearyRepository extends DocumentRepository
{
    public function findAll()
    {
        return $this->createQueryBuilder("MilleEtangsRandonneesBundle:Itineary")
            ->field("published")->equals(true)
            ->getQuery()
            ->execute()
        ;
    }
}
