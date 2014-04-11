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

use Dacorp\ExtraBundle\DacorpExtraEvents;
use Dacorp\ExtraBundle\Event\LangPreferenceEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Default controller for standard services.
 *
 * @author jmeyo Jean-Christophe Meillaud
 */

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DacorpExtraBundle:Default:index.html.twig');
    }

    public function home2Action()
    {
        /* Important, may be the main redirection */
        $securityContext = $this->get('security.context');

        // redirect to home if user is already logged in
        if ($securityContext->isGranted('ROLE_AUTHENTICATED')) {
            return $this->render('DacorpExtraBundle::home.html.twig');
        }
        $CSRFToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');

        return $this->render('DacorpExtraBundle:User:register.html.twig', array(
                'csrf_token' => $CSRFToken
            )
        );
    }

    public function switchLanguageAction($newlang)
    {
        $event = new LangPreferenceEvent($newlang);
        $this->get('event_dispatcher')->dispatch(DacorpExtraEvents::AUTHENTICATED_USER_CHANGE_LANG, $event);

        $this->get('session')->set('_locale', $newlang);

        $referrerUrl = $this->get('request')->headers->get('referer');
        if ($referrerUrl != null) {
            return $this->redirect($referrerUrl);
        } else {
            return $this->redirect($this->generateUrl('apps'));
        }
    }

}
