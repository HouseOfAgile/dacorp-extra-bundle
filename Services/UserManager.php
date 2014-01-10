<?php

/*
 * This file is part of the Dacorp Extra Bundle
 *
 * (c) Jean-Christophe Meillaud
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Dacorp\ExtraBundle\Services;

//use FOS\UserBundle\Model\UserManager as UM

use Dacorp\ExtraBundle\Entity\User;
use Dacorp\ExtraBundle\Entity\UserStat;
use FOS\UserBundle\Doctrine\UserManager as BaseUserManager;
use FOS\UserBundle\Model\UserInterface;

class UserManager extends BaseUserManager
{
    /**
     * Returns an empty user instance
     *
     * @return UserInterface
     */
    public function createUser()
    {
        /* @var User $user */
        $user = parent::createUser();

        $userStat = new UserStat();
        $user->setUserStat($userStat);
        return $user;
    }

}