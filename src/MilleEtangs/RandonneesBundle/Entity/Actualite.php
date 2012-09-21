<?php

namespace MilleEtangs\RandonneesBundle\Entity;

use Symfony\Component\Validator\Constraint as Assert;
use Doctrine\ORM\Mapping as ORM;

class Actualite
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 *
	 */
	protected $slug;

	/**
	 *
	 */
	protected $message;

	/**
	 *
	 */
	protected $created;

	/**
	 *
	 */
	protected $updated;



}