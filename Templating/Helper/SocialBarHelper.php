<?php

/*
 * This file is part of the Dacorp Extra Bundle
 *
 * (c) Jean-Christophe Meillaud
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dacorp\ExtraBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\Templating\EngineInterface;

class SocialBarHelper extends Helper
{
    protected $templating;

    public function __construct(EngineInterface $templating)
    {
        $this->templating  = $templating;
    }


    public function socialButtons($parameters)
    {
        return $this->templating->render('DacorpExtraBundle:Widgets:socialButtons.html.twig', $parameters);
    }

    public function facebookButton($parameters)
    {
        return $this->templating->render('DacorpExtraBundle:Widgets:facebookButton.html.twig', $parameters);
    }

    public function twitterButton($parameters)
    {
        return $this->templating->render('DacorpExtraBundle:Widgets:twitterButton.html.twig', $parameters);
    }

    public function googlePlusButton($parameters)
    {
        return $this->templating->render('DacorpExtraBundle:Widgets:googlePlusButton.html.twig', $parameters);
    }

    public function pinterestButton($parameters)
    {
        return $this->templating->render('DacorpExtraBundle:Widgets:pinterestButton.html.twig', $parameters);
    }

    public function getName()
    {
        return 'socialButtons';
    }
}