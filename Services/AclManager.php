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

use Problematic\AclManagerBundle\Domain\AclManager as ProblematicAclManager;

/**
 * Extending the Default Problematic AclManager, mainly ACL related actions, no business logic
 */
class AclManager extends ProblematicAclManager
{
    public function addArrayObjectPermission($domainObjects, $mask, $securityIdentity = null)
    {
        foreach ($domainObjects as $domainObject) {
            $this->addPermission($domainObject, $mask, $securityIdentity, 'object', false);
        }
    }

}