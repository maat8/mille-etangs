<?php

namespace MilleEtangs\RandonneesBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

class ItinearyRepository extends DocumentRepository
{
    public function findAllBike()
    {
        return $this->createQueryBuilder("MilleEtangsRandonneesBundle:Itineary")
            ->where("function() { return this.bike_length > 0; }")
            ->getQuery()
            ->execute()
        ;
    }

    public function findAllHike()
    {
        return;
    }

    public function findAllByType($type)
    {
        switch($type){
            case 'hike':
                return $this->findAllHike();
            case 'bike':
            default:
                return $this->findAllBike();
        }
    }
}
