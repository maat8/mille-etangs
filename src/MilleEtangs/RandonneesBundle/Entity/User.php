<?php

namespace MilleEtangs\RandonneesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue()
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=32)
	 */
	protected $username;

	/**
	 * @ORM\Column(type="string", length=128)
	 */
	protected $password;

	/**
	 * @ORM\Column(type="string", length=32)
	 */
	protected $passwordSalt;

	public function getUserName()
	{
		return $this->username;
	}

	public function getRoles()
	{
		return array('ROLE_USER', 'ROLE_ADMIN');
	}

	public function getSalt()
	{
		return $this->passwordSalt;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function equals(UserInterface $user)
    {
        return $user->getId() == $this->getId();
    }

	public function eraseCredentials(){
		return;
	}

	public function regenerateSalt()
    {
        return $this->passwordSalt = md5(microtime() . uniqid());
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set passwordSalt
     *
     * @param string $passwordSalt
     * @return User
     */
    public function setPasswordSalt($passwordSalt)
    {
        $this->passwordSalt = $passwordSalt;
    
        return $this;
    }

    /**
     * Get passwordSalt
     *
     * @return string 
     */
    public function getPasswordSalt()
    {
        return $this->passwordSalt;
    }
}