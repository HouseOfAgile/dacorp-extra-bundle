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
use Dacorp\ExtraBundle\Entity\UserStat;

/**
 * @ORM\Entity
 * @ORM\Table(name="dacore_user")
 * @ORM\Entity(repositoryClass="Dacorp\ExtraBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("email")
 *
 *  */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->avatar = new ArrayCollection();
        // your own logic
    }

    /**
     * dirty hack in order to not rename all getUserId might be updated later....
     */
    public function getUserId()
    {
        return parent::getId();
    }

    /**
     * @var string $firstname
     *
     * @ORM\Column(name="firstname", type="string", length=20, nullable=true)
     */
    private $firstname;

    /**
     * @var date $birthdate
     *
     * @ORM\Column(name="birthdate", type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @var Address
     *
     * @ORM\ManyToOne(targetEntity="Dacorp\ExtraBundle\Entity\Address",cascade={"persist"})
     * @ORM\JoinColumn(name="address_id", referencedColumnName="address_id", onDelete="RESTRICT")
     */
    private $address;

    /**
     * @var string $lastname
     *
     * @ORM\Column(name="lastname", type="string", length=20, nullable=true)
     */
    private $lastname;

    /* TODO , deal with roles */

    /**
     * @var UserRole
     *
     * @ORM\ManyToOne(targetEntity="UserRole")
     * @ORM\JoinColumn(name="user_role_id", referencedColumnName="user_role_id", onDelete="RESTRICT", nullable=true)
     */
    private $userRole;

    /**
     * @var DacorpMedia $pictures
     * @ORM\OneToMany(targetEntity="DacorpMedia",mappedBy="user")
     */
    private $pictures;

    /**
     * @var DacorpMedia $currentAvatar
     * @ORM\OneToOne(targetEntity="DacorpMedia")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="media_id")
     */
    private $currentAvatar;

    /**
     * @var UserStat $userStat
     *
     * @ORM\OneToOne(targetEntity="Dacorp\ExtraBundle\Entity\UserStat",cascade={"persist"})
     * @ORM\JoinColumn(name="user_stat_id", referencedColumnName="user_stat_id", onDelete="SET NULL")
     */
    private $userStat;

    /**
     * Reputation
     * @var integer $reputation
     *
     * @ORM\Column(name="user_reputation", type="integer", nullable=true)
     */
    private $reputation=1;
    
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
     * Set nbVoteUp
     *
     * @param integer $nbVoteUp
     * @return User
     */
    public function setNbVoteUp($nbVoteUp)
    {
        $this->nbVoteUp = $nbVoteUp;
    
        return $this;
    }

    /**
     * Get nbVoteUp
     *
     * @return integer 
     */
    public function getNbVoteUp()
    {
        return $this->nbVoteUp;
    }

    /**
     * Set nbVoteDown
     *
     * @param integer $nbVoteDown
     * @return User
     */
    public function setNbVoteDown($nbVoteDown)
    {
        $this->nbVoteDown = $nbVoteDown;
    
        return $this;
    }

    /**
     * Get nbVoteDown
     *
     * @return integer 
     */
    public function getNbVoteDown()
    {
        return $this->nbVoteDown;
    }

    /**
     * Set nbRating
     *
     * @param integer $nbRating
     * @return User
     */
    public function setNbRating($nbRating)
    {
        $this->nbRating = $nbRating;
    
        return $this;
    }

    /**
     * Get nbRating
     *
     * @return integer 
     */
    public function getNbRating()
    {
        return $this->nbRating;
    }

    /**
     * Set nbComment
     *
     * @param integer $nbComment
     * @return User
     */
    public function setNbComment($nbComment)
    {
        $this->nbComment = $nbComment;
    
        return $this;
    }

    /**
     * Get nbComment
     *
     * @return integer 
     */
    public function getNbComment()
    {
        return $this->nbComment;
    }

    /**
     * Set nbPictures
     *
     * @param integer $nbPictures
     * @return User
     */
    public function setNbPictures($nbPictures)
    {
        $this->nbPictures = $nbPictures;
    
        return $this;
    }

    /**
     * Get nbPictures
     *
     * @return integer 
     */
    public function getNbPictures()
    {
        return $this->nbPictures;
    }

    /**
     * Set address
     *
     * @param \Dacorp\ExtraBundle\Entity\Address $address
     * @return User
     */
    public function setAddress(\Dacorp\ExtraBundle\Entity\Address $address = null)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return \Dacorp\ExtraBundle\Entity\Address 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set userRole
     *
     * @param \Dacorp\ExtraBundle\Entity\UserRole $userRole
     * @return User
     */
    public function setUserRole(\Dacorp\ExtraBundle\Entity\UserRole $userRole = null)
    {
        $this->userRole = $userRole;
    
        return $this;
    }

    /**
     * Get userRole
     *
     * @return \Dacorp\ExtraBundle\Entity\UserRole 
     */
    public function getUserRole()
    {
        return $this->userRole;
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
     * Set userStat
     *
     * @param \Dacorp\ExtraBundle\Entity\UserStat $userStat
     * @return User
     */
    public function setUserStat(\Dacorp\ExtraBundle\Entity\UserStat $userStat = null)
    {
        $this->userStat = $userStat;
    
        return $this;
    }

    /**
     * Get userStat
     *
     * @return \Dacorp\ExtraBundle\Entity\UserStat 
     */
    public function getUserStat()
    {
        return $this->userStat;
    }

    /**
     * Set reputation
     *
     * @param integer $reputation
     * @return User
     */
    public function setReputation($reputation)
    {
        $this->reputation = $reputation;
    
        return $this;
    }

    /**
     * Get reputation
     *
     * @return integer 
     */
    public function getReputation()
    {
        return $this->reputation;
    }

    /**
     * Add pictures
     *
     * @param \Dacorp\ExtraBundle\Entity\DacorpMedia $pictures
     * @return User
     */
    public function addPicture(\Dacorp\ExtraBundle\Entity\DacorpMedia $pictures)
    {
        $this->pictures[] = $pictures;
    
        return $this;
    }

    /**
     * Remove pictures
     *
     * @param \Dacorp\ExtraBundle\Entity\DacorpMedia $pictures
     */
    public function removePicture(\Dacorp\ExtraBundle\Entity\DacorpMedia $pictures)
    {
        $this->pictures->removeElement($pictures);
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPictures()
    {
        return $this->pictures;
    }
}
