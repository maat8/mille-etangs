<?php

namespace MilleEtangs\RandonneesBundle\Entity;

use Symfony\Component\Validator\Constraint as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="MilleEtangs\RandonneesBundle\Repository\HotellerieRepository")
 * @ORM\Table(name="hotelleries")
 * @ORM\HasLifecycleCallbacks
 */
class Hotellerie extends EntityBase
{
}