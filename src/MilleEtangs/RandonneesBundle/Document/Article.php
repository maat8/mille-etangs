<?php

namespace MilleEtangs\RandonneesBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(collection="articles", repositoryClass="MilleEtangs\RandonneesBundle\Repository\ArticleRepository")
 */
class Article extends BaseDocument
{
    /**
     * @ODM\Field(type="string")
     */
    protected $content;

    /**
     * @ODM\Field(type="date")
     * @ODM\Index
    */
    protected $publication;

    public function __construct()
    {
        $this->publication = new \DateTime();
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Actualite
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set publication
     *
     * @param \Date $publication
     * @return Actualite
     */
    public function setPublication($publication = null)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return \Date
     */
    public function getPublication()
    {
        return $this->publication;
    }
}
