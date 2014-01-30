<?php

namespace MilleEtangs\RandonneesBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

class ItinearyRepository extends DocumentRepository
{
    public function findAllBike()
    {
        return $this->createQueryBuilder("MilleEtangsRandonneesBundle:Itineary")
            ->where("function() { return this.bikeLength > 0; }")
            ->getQuery()
            ->execute()
        ;
    }

    public function findAllHike()
    {
        return $this->createQueryBuilder("MilleEtangsRandonneesBundle:Itineary")
            ->where("function() { return this.hikeLength > 0; }")
            ->getQuery()
            ->execute()
        ;
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
