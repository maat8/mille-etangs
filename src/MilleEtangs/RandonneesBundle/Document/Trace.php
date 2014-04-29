<?php

namespace MilleEtangs\RandonneesBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    public function __construct($content = null)
    {
        if (!is_null($content)) {
            file_put_contents($file = tempnam(sys_get_temp_dir(), "trace"), $content);
            $this->setFile($file);
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }
}
