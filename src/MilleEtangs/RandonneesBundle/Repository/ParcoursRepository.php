<?php

namespace MilleEtangs\RandonneesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ParcoursRepository extends EntityRepository
{
    public function findAllVtt()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT p FROM MilleEtangsRandonneesBundle:Parcours p WHERE p.duree_vtt > 0 ORDER BY p.nom ASC')
            ->getResult();
    }

    public function findAllMarche()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT p FROM MilleEtangsRandonneesBundle:Parcours p WHERE p.duree_marche > 0 ORDER BY p.nom ASC')
            ->getResult();
    }

    public function findAllCheval()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT p FROM MilleEtangsRandonneesBundle:Parcours p WHERE p.duree_cheval > 0 ORDER BY p.nom ASC')
            ->getResult();
    }
}