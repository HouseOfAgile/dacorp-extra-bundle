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

class MetaWidgetHelper extends Helper
{
    protected $templating;

    public function __construct(EngineInterface $templating)
    {
        $this->templating  = $templating;
    }

    public function allMetas($parameters)
    {
        return $this->templating->render('DacorpExtraBundle:Widgets/Meta:allMetas.html.twig', $parameters);
    }

    public function twitterCard($parameters)
    {
        return $this->templating->render('DacorpExtraBundle:Widgets/Meta:twitterCard.html.twig', $parameters);
    }

    public function facebookOpenGraph($parameters)
    {
        return $this->templating->render('DacorpExtraBundle:Widgets/Meta:facebookOpenGraph.html.twig', $parameters);
    }


    public function getName()
    {
        return 'metaWidget';
    }
}