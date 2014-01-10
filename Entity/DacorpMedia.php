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

use Dacorp\ExtraBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Dacorp\ExtraBundle\Entity\DacorpMedia
 *
 *
 * @ORM\Table(name="dacore_dacorpmedia")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("url")
 */
class DacorpMedia
{

    /**
     * @var integer $mediaId
     *
     * @ORM\Column(name="media_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $mediaId;


    /**
     * @var User $user
     * @ORM\ManyToOne(targetEntity="User", inversedBy="pictures")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id", nullable=true, onDelete="CASCADE")
     */
    private $user;

    /**
     * @var string $filename
     *
     * @ORM\Column(name="filename", type="string", length=255, nullable=true)
     */
    private $filename;
    /**
     * @var string $originalFilename
     *
     * @ORM\Column(name="orig_filename", type="string", length=255, nullable=true)
     */
    private $originalFilename;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;


    public function __toString()
    {
        return'<br/>mediaId:'.$this->getMediaId().',filename:'.$this->filename.',url:'.$this->url.',user:'.$this->getUser();
    }

    /**
     * Get media
     *
     * @return integer 
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }

    /**
     * Set filename
     *
     * @param string $filename
     * @return DacorpMedia
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    
        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return DacorpMedia
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set user
     *
     * @param \Dacorp\ExtraBundle\Entity\User $user
     * @return DacorpMedia
     */
    public function setUser(\Dacorp\ExtraBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Dacorp\ExtraBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set originalFilename
     *
     * @param string $originalFilename
     * @return DacorpMedia
     */
    public function setOriginalFilename($originalFilename)
    {
        $this->originalFilename = $originalFilename;
    
        return $this;
    }

    /**
     * Get originalFilename
     *
     * @return string 
     */
    public function getOriginalFilename()
    {
        return $this->originalFilename;
    }
}