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

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Dacorp\ExtraBundle\Entity\DacorpMedia;

/**
 * @ORM\Entity
 * @ORM\Table(name="dacore_user_stat")
 * @ORM\HasLifecycleCallbacks
 *
 *  */
class UserStat
{

    /**
     * @ORM\Id
     * @ORM\Column(name="user_stat_id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * Number of vote Up
     * @var integer $nbVoteUp
     *
     * @ORM\Column(name="user_nb_vote_up", type="smallint", nullable=true)
     */
    private $nbVoteUp=0;

    /**
     * Number of vote Down
     * @var integer $nbVoteDown
     *
     * @ORM\Column(name="user_nb_vote_down", type="smallint", nullable=true)
     */
    private $nbVoteDown=0;

    /**
     * Number of Rating
     * @var integer $nbRating
     *
     * @ORM\Column(name="user_nb_rating", type="smallint", nullable=true)
     */
    private $nbRating=1;


    /**
     * Number of comments
     * @var float $nbComments
     *
     * @ORM\Column(name="user_nb_comments", type="smallint", nullable=true)
     */
    private $nbComments=0;


    /**
     * Number of Pictures uploaded
     * @var float $nbPictures
     *
     * @ORM\Column(name="user_nb_pictures", type="smallint", nullable=true)
     */
    private $nbPictures=0;

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
     * Set nbComments
     *
     * @param integer $nbComments
     * @return UserStat
     */
    public function setNbComments($nbComments)
    {
        $this->nbComments = $nbComments;
    
        return $this;
    }

    /**
     * Get nbComments
     *
     * @return integer 
     */
    public function getNbComments()
    {
        return $this->nbComments;
    }
}