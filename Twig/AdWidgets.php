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

class AdWidgets extends \Twig_Extension
{

    protected $container;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getName()
    {
        return 'dacorp_ad_widgets';
    }

    public function getFunctions()
    {
        return array(
            'adWidgets' => new \Twig_Function_Method($this, 'getAdWidgets', array('is_safe' => array('html')))
        );
    }

    public function getAdWidgets($parameters = array())
    {
        return $this->container->get('dacorp.adHelper')->getAdSense($parameters);
    }

}

?>