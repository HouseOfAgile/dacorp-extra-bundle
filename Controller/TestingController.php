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

use Dacorp\PictureBundle\Form\Type\PictureTagFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestingController extends Controller
{

    public function testAction()
    {
        $tag = $this->get('dacorp.manager.tags')->create();

        $em = $this->getDoctrine()->getManager();

        $picture = $em->getRepository('DacorpPictureBundle:Picture')->find('1');

        $tagform = $this->createForm(new PictureTagFormType(), $tag, array('picId' => 1));

        return $this->render('DacorpExtraBundle:Testing:test.html.twig', array(
                'tagform' => $tagform->createView(),
                'picture' => $picture

            )
        );
    }

}
