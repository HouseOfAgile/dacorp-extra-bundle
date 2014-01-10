<?php

/*
 * This file is part of the Dacorp Extra Bundle
 *
 * (c) Jean-Christophe Meillaud
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dacorp\ExtraBundle\Listener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\ORM\EntityManager;

/**
 * Custom login listener.
 */
class LoginListener
{

    /** @var \Symfony\Component\Security\Core\SecurityContext */
    private $context;

    /** @var \Doctrine\ORM\EntityManager */
    private $em;

    /** @var \Symfony\Component\HttpFoundation\Session\Session */
    private $session;

    private $container;

    /**
     * Constructor
     * 
     * @param SecurityContext $context
     * @param Doctrine        $doctrine
     */
    public function __construct(SecurityContext $context, EntityManager $em, Session $session, Container $container)
    {
        $this->context = $context;
        $this->em = $em;
        $this->session = $session;
        $this->container = $container;
    }

    /**
     * Save the schoolId and group Id's in the session during login
     * 
     * @param Event $event
     */
    public function onSecurityInteractiveLogin(Event $event)
    {
    }

}