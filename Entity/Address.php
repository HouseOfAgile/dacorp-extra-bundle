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

use Doctrine\ORM\Mapping as ORM;

/**
 * Dacorp\ExtraBundle\Entity\Address
 *
 * @ORM\Table(name="dacore_address")
 * @ORM\Entity
 */
class Address
{
    /**
     * @var integer $addressId
     *
     * @ORM\Column(name="address_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $addressId;

    /**
     * @var string $location
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=true)
     */
    protected $location;

    /**
     * @var string $street
     *
     * @ORM\Column(name="street", type="string", length=255, nullable=true)
     */
    protected $street;

    /**
     * @var string $zipcode
     *
     * @ORM\Column(name="zipcode", type="string", length=20, nullable=true)
     */
    protected $zipcode;

    /**
     * @var string $streetNr
     *
     * @ORM\Column(name="street_nr", type="string", length=20, nullable=true)
     */
    protected $streetNr;

    /**
     * @var State
     *
     * @ORM\ManyToOne(targetEntity="State")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="state_id", onDelete="RESTRICT")
     */
    protected $state;



    /**
     * Get addressId
     *
     * @return integer
     */
    public function getAddressId()
    {
        return $this->addressId;
    }

    /**
     * Set location
     *
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set street
     *
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    /**
     * Get zipcode
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set streetNr
     *
     * @param string $streetNr
     */
    public function setStreetNr($streetNr)
    {
        $this->streetNr = $streetNr;
    }

    /**
     * Get streetNr
     *
     * @return string
     */
    public function getStreetNr()
    {
        return $this->streetNr;
    }

    /**
     * Set state
     *
     * @param Dacorp\ExtraBundle\Entity\State $state
     */
    public function setState(\Dacorp\ExtraBundle\Entity\State $state)
    {
        $this->state = $state;
    }

    /**
     * Get state
     *
     * @return Dacorp\ExtraBundle\Entity\State
     */
    public function getState()
    {
        return $this->state;
    }
}