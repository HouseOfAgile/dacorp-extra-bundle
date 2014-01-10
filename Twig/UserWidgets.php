<?php

/*
 * This file is part of the Dacorp Extra Bundle
 *
 * (c) Jean-Christophe Meillaud
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Dacorp\ExtraBundle\Twig;

use Twig_Extension;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Twig_Filter_Method;

class UserWidgets extends Twig_Extension
{

    /**
     * Logger
     * @var type 
     */
    protected $logger;
    protected $themeAttributes;

    /**
     * Container
     * @var type 
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->logger = $this->container->get('logger');
    }

    public function getFilters()
    {
        return array(
            'genUserCard' => new Twig_Filter_Method($this, 'genUserCard'),
        );
    }

    public function getGlobals()
    {
  
    }

    public function genUserCard()
    {
        
    }

    public function getName()
    {
        return 'dacorp_userwidgets';
    }

}