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

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Templating\EngineInterface;

class SocialNetworkExtension extends \Twig_Extension
{

    protected $socialNetworkUrl = array(
        'facebook' => 'https://www.facebook.com/',
        'twitter' => 'https://twitter.com/',
        'linkedin' => 'https://www.linkedin.com/',
    );

    /* @var ContainerInterface  $container */
    protected $container;

    protected $activeSocialNetworks;

    /**
     * @param EngineInterface $templating
     */
    public function __construct(ContainerInterface $container, $activeSocialNetworks)
    {
        $this->container = $container;
        $this->activeSocialNetworks = $activeSocialNetworks;
    }

    public function getName()
    {
        return 'dacorp_social_network';
    }

    public function getFunctions()
    {
        return array(
            'sociallinks' => new \Twig_Function_Method($this, 'getSocialLinks', array('is_safe' => array('html'))),
        );
    }

    public function getSocialLinks($parameters = array())
    {
        foreach ($this->activeSocialNetworks as $snk => $snv) {
            $parameters['socialNetworks'][$snk] = $this->socialNetworkUrl[$snk] .$snv;
        }

        return $this->container->get('templating')->render('DacorpExtraBundle:Widgets/SocialNetwork:socialLinks.html.twig', $parameters);

    }
}

?>