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
 * Dacorp\ExtraBundle\Entity\AbstractDacorpMedia
 *
 *
 * @ORM\Table(name="dacore_abstract_dacorpmedia")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("url")
 */
class AbstractDacorpMedia
{

    /**
     * @var integer $mediaId
     *
     * @ORM\Column(name="media_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $mediaId;



    /**
     * @var string $filename
     *
     * @ORM\Column(name="filename", type="string", length=255, nullable=true)
     */
    protected $filename;
    /**
     * @var string $originalFilename
     *
     * @ORM\Column(name="orig_filename", type="string", length=255, nullable=true)
     */
    protected $originalFilename;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    protected $url;


    public function __toString()
    {
        return'<br/>mediaId:'.$this->getMediaId().',filename:'.$this->filename.',url:'.$this->url;
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