<?php

namespace MilleEtangs\RandonneesBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(collection="traces")
 */
class Trace
{
    /** @ODM\Id */
    protected $id;

    /** @ODM\Field */
    protected $name;

    /** @ODM\File */
    protected $file;

    /** @ODM\Field */
    protected $uploadDate;

    /** @ODM\Field */
    protected $length;

    /** @ODM\Field */
    protected $chunkSize;

    /** @ODM\Field */
    protected $md5;

    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    protected function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param mixed $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the value of file.
     *
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Sets the value of file.
     *
     * @param mixed $file the file
     *
     * @return self
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Gets the value of uploadDate.
     *
     * @return mixed
     */
    public function getUploadDate()
    {
        return $this->uploadDate;
    }

    /**
     * Gets the value of length.
     *
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Gets the value of chunkSize.
     *
     * @return mixed
     */
    public function getChunkSize()
    {
        return $this->chunkSize;
    }

    /**
     * Gets the value of md5.
     *
     * @return mixed
     */
    public function getMd5()
    {
        return $this->md5;
    }
}
