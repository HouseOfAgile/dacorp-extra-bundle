<?php
/*
 * This file is part of the Dacorp Extra Bundle
 *
 * (c) Jean-Christophe Meillaud
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Dacorp\ExtraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Docs controller for simple rendering of README.md files.
 *
 * @author jmeyo Jean-Christophe Meillaud
 */

class DocsController extends Controller
{
    
    public function readMeAction() {
        $filePath = $this->get('kernel')->getRootDir() . "/../README.md";
        $text = file_get_contents($filePath);
        $html = $this->container->get('markdown.parser')->transformMarkdown($text);
        return $this->render('DacorpExtraBundle:Docs:readme.html.twig', array("readme" => $html ));
    }

    public function readMeDacorpAction() {
        $kernel = $this->get('kernel');
        $filePath = $kernel->locateResource('@DacorpExtraBundle/README.md');
        $text = file_get_contents($filePath);
        $html = $this->container->get('markdown.parser')->transformMarkdown($text);
        return $this->render('DacorpExtraBundle:Docs:readme.html.twig', array("readme" => $html ));
    }
    
}
