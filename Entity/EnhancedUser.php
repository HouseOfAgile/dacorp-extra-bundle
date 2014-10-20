<?php

/*
 * This file is part of the Dacorp Extra Bundle
 *
 * (c) Jean-Christophe Meillaud
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Dacorp\ExtraBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Dacorp\ExtraBundle\Entity\DacorpMedia;


class EnhancedUser extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }


    /**
     * @var string $firstname
     *
     * @ORM\Column(name="firstname", type="string", length=20, nullable=true)
     */
    protected $firstname;

    /**
     * @var date $birthdate
     *
     * @ORM\Column(name="birthdate", type="date", nullable=true)
     */
    protected $birthdate;


    /**
     * @var string $lastname
     *
     * @ORM\Column(name="lastname", type="string", length=20, nullable=true)
     */
    protected $lastname;


    /**
     * @var DacorpMedia $currentAvatar
     * @ORM\OneToOne(targetEntity="DacorpMedia")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="media_id")
     */
    private $currentAvatar;

    /**
     * @ORM\Column(name="locale", type="string", length=5, nullable=true)
     *
     */
    protected $locale;

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
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set currentAvatar
     *
     * @param \Dacorp\ExtraBundle\Entity\DacorpMedia $currentAvatar
     * @return User
     */
    public function setCurrentAvatar(\Dacorp\ExtraBundle\Entity\DacorpMedia $currentAvatar = null)
    {
        $this->currentAvatar = $currentAvatar;

        return $this;
    }

    /**
     * Get currentAvatar
     *
     * @return \Dacorp\ExtraBundle\Entity\DacorpMedia
     */
    public function getCurrentAvatar()
    {
        return $this->currentAvatar;
    }

    /**
     * Set locale
     *
     * @param \DateTime $locale
     * @return User
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return \DateTime
     */
    public function getLocale()
    {
        return $this->locale;
    }
}
