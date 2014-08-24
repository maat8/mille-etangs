<?php

namespace MilleEtangs\RandonneesBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

class ArticleRepository extends DocumentRepository
{
    public function findLastPublishedArticles($limit = 10)
    {
        return $this->createQueryBuilder("MilleEtangsRandonneesBundle:Article")
            ->where("function () { return this.publication <= new Date(); }")
            ->sort("publication", "desc")
            ->limit($limit)
            ->getQuery()
            ->execute()
        ;
    }
}
