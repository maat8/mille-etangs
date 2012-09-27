<?php

namespace MilleEtangs\RandonneesBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;


class Evenement extends EntityBase
{
	// events = marche, vtt, équitation, culturel, animation

	protected $categorie;

	protected $date;

}