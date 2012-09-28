<?php

namespace MilleEtangs\RandonneesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ActualiteRepository extends EntityRepository
{
	public function findAllActualitesPubliees()
	{
		return $this->createQueryBuilder("a")
			->where("a.publication <= CURRENT_DATE()")
			->orderBy("a.publication", "DESC")
			->setMaxResults(5)
			->getQuery()
			->execute()
		;
	}
}