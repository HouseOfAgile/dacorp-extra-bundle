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

class MetaExtension extends \Twig_Extension
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
        return 'dacorp_meta';
    }

    public function getFunctions()
    {
        return array(
            'allMetas' => new \Twig_Function_Method($this, 'getAllMetas', array('is_safe' => array('html'), 'type' => 'box')),
            'twitterCard' => new \Twig_Function_Method($this, 'getTwitterCard', array('is_safe' => array('html'), 'type' => 'horizontal')),
            'facebookOpenGraph' => new \Twig_Function_Method($this, 'getFacebookOpenGraph', array('is_safe' => array('html'))),
        );
    }
    public function getAllMetas($parameters = array())
    {
        $parameters = $parameters + array(

            );


        return $this->container->get('dacorp.metaWidgetHelper')->allMetas($parameters);
    }

    public function getTwitterCard($parameters = array())
    {
        $parameters = $parameters + array(
                'url' => null,
                'locale' => 'en',
                'message' => 'I want to share that page with you',
                'text' => 'Tweet',
                'via' => 'justmoovParis',
                'count' => 'horizontal',
                'tag' => false,

            );


        return $this->container->get('dacorp.metaWidgetHelper')->twitterCard($parameters);
    }


}