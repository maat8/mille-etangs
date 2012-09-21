<?php

namespace MilleEtangs\RandonneesBundle\Entity;

use Symfony\Component\Validator\Constraint as Assert;
use Doctrine\ORM\Mapping as ORM;

class Actualite extends EntityBase
{
	/**
	 *
	 */
	protected $message;

	/*
		categories actus = event, parcours, divers, partenaires,
	*/
}