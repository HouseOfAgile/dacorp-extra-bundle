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

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class DataManager
{

    /**
     * Holds the Doctrine entity manager for database interaction
     * @var EntityManager
     */
    protected $em;

    /**
     * Entity-specific repo, useful for finding entities, for example
     * @var EntityRepository
     */
    protected $repo;

    /**
     * The Fully-Qualified Class Name for our entity
     * @var string
     */
    protected $class;

    /**
     * Container
     * @var type
     * TODO : remove container if possible, see CHD-1
     */
    protected $container;

    public function __construct(EntityManager $em, Container $container, $class)
    {
        $this->em = $em;
        $this->class = $class;
        $this->repo = $em->getRepository($class);
        $this->container = $container;
    }

    /**
     */
    public function create()
    {
        $class = $this->class;
        $content = new $class();

        return $content;
    }

    public function saveChanges()
    {
        $this->em->flush();
    }

    public function delete($content)
    {
        $this->em->remove($content);
        $this->saveChanges();
    }

    public function getUser() {
        return $this->container->get('security.context')->getToken()->getUser();
    }

}