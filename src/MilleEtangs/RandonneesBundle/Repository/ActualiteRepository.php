<?php

namespace MilleEtangs\RandonneesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ActualiteRepository extends EntityRepository
{
	public function findLastActualitesPubliees($limit = 10)
	{
		return $this->createQueryBuilder("a")
			->where("a.publication <= CURRENT_DATE()")
			->orderBy("a.publication", "DESC")
			->setMaxResults($limit)
			->getQuery()
			->execute()
		;
	}
}