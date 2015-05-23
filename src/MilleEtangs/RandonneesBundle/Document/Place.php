<?php

namespace MilleEtangs\RandonneesBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(collection="places")
 */
class Place extends BaseDocument
{
	/**
     * @ODM\EmbedOne(targetDocument="Point")
     */
	protected $point;

	/**
     * @ODM\Field(type="string")
     */
    protected $description;
}
