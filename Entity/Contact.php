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

use Mremi\ContactBundle\Entity\Contact as BaseContact;

/**
 * Class Contact
 * @package Dacorp\ExtraBundle\Entity
 */
class Contact extends BaseContact
{
    /**
     * @var integer
     */
    protected $id;
}