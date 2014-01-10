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

use Doctrine\ORM\EntityManager;
use Dacorp\ExtraBundle\Entity\Group;
use Dacorp\ExtraBundle\Entity\User;
use Dacorp\ExtraBundle\Services\AclManager;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContext;

class DacorpAclService extends AclManager
{

    /**
     * Holds the Doctrine entity manager for database interaction
     * @var EntityManager
     */
    protected $em;

    /**
     * AclManager
     * @var AclManager
     */
    protected $aclManager;

    /** @var SecurityContext */
    private $context;

    public function __construct(EntityManager $em, AclManager $aclManager, SecurityContext $context)
    {
        $this->em = $em;
        $this->aclManager = $aclManager;
        $this->context = $context;
    }

    public function createAclForUser($domainObject, User $user, $mask = array('OWNER'))
    {
        // creating the ACL
        $objectIdentity = ObjectIdentity::fromDomainObject($domainObject);
        $acl = $this->aclManager->getAclProvider()->createAcl($objectIdentity);

        // retrieving the security identity of the currently logged-in user
        $securityIdentity = UserSecurityIdentity::fromAccount($user);


        // grant owner access
        $acl->insertObjectAce($securityIdentity, $this->getMask($mask));
        $this->aclManager->getAclProvider()->updateAcl($acl);
    }

    public function checkACL($businessObject, $permission)
    {
        // check for edit access
        if (false === $this->context->isGranted($permission, $businessObject)) {
            throw new AccessDeniedException();
        }
    }

    private function getMask($maskArray)
    {
        if (!is_array($maskArray)) {
            $maskArray = array($maskArray);
        }
        $builder = new MaskBuilder();

        foreach ($maskArray as $mask) {
            $builder->add($mask);
        }
        return $builder->get();
    }
    
    public function deleteAclForGroupPublication($domainObject, Group $group, User $user, $mask = array('view'))
    {
        $this->aclManager->revokePermission($domainObject, $this->getMask($mask), $user, 'object', false);
    }
}
