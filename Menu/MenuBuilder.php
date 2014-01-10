<?php

/*
 * This file is part of the Dacorp Extra Bundle
 *
 * (c) Jean-Christophe Meillaud
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dacorp\ExtraBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Class MenuBuilder
 * @TODO move to image project as it is specific
 * @package Dacorp\ExtraBundle\Menu
 * @author jmeyo@github
 */
class MenuBuilder extends ContainerAware
{
    protected $factory;

    /**
     * Container
     * @var type
     */
    protected $container;

    protected $translator;

    /**
     * @param FactoryInterface $factory
     * @param Container $container
     */
    public function __construct(FactoryInterface $factory, Container $container)
    {
        $this->container = $container;
        $this->factory = $factory;
        $this->translator = $container->get('translator');
    }

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        /* @var $leftMenu ItemInterface */
        $mainMenu = $factory->createItem('root', array(
            'navbar' => true,
        ));

        $mainMenu->setChildrenAttribute('class', 'nav navbar-nav');
        $mainMenu->addChild($this->translator->trans('navbar.mainlink.latest'), array(
            'route' => 'dacorp_picture_list',
            'routeParameters' => array('listFilter' => 'latest', 'order' => 'DESC')));
        $mainMenu->addChild($this->translator->trans('navbar.mainlink.popular'), array(
            'route' => 'dacorp_picture_list',
            'routeParameters' => array('listFilter' => 'nbVoteUp', 'order' => 'DESC')));
        $mainMenu->addChild($this->translator->trans('navbar.upload-button'), array('route' => 'dacorp_picture_create'));
        return $mainMenu;
    }

    public function userMenu(FactoryInterface $factory, array $options)
    {
        $userMenu = $factory->createItem('root', array(
            'navbar' => true,
            'push_right' => true,

        ));
        $securityContext = $this->container->get('security.context');
        $label = ($securityContext->isGranted('IS_AUTHENTICATED_FULLY') ? $this->container->get('security.context')->getToken()->getUserName() : '');

        $userMenuDropDown = $userMenu->addChild($label, array(
            'caret' => true,
            'dropdown' => true
        ));
        $userMenuDropDown->addChild(
            $this->container->get('translator')->trans('navbar.member.menu.show_own_profile'), array('route' => 'show_own_profile')
        );
        $userMenuDropDown->addChild(
            $this->container->get('translator')->trans('navbar.member.menu.show_booking'), array('route' => 'edit_own_profile')
        );

        //Add an icon to logout
        /** @Ignore */
        $userMenu->addChild(
            $this->container->get('translator')->trans('routename.fos_user_security_logout'), array(
                'route' => 'fos_user_security_logout',
                /** @Ignore */
                'label' => /** @Ignore */
                '<span class="glyphicon glyphicon-log-out"></span>',
                'extras' => array(
                    'safe_label' => true
                ))
        );

        return $userMenu;
    }



    public function rightMenu(FactoryInterface $factory, array $options)
    {
        $rightMenu = $factory->createItem('lang', array(
            'navbar' => true,
            'push_right' => true,
        ));

        //Add a dropdown to switch languages
        $currLang = $this->container->get('session')->get('_locale', $this->container->getParameter('locale'));
        $available_langs = $this->container->getParameter('available_langs');

// TODO Fix glyphicon
//        $dropdownLang = $this->createDropdownMenuItem(
//            $menu, $currLang, true, array('glyphicon' => 'glyphicon glyphicon-flag'), array()
//        );

        $userMenuDropDown = $rightMenu->addChild($currLang, array(
            'caret' => true,
            'dropdown' => true,
            'glyphicon' => 'glyphicon glyphicon-flag'
        ));
        //create the childs
        foreach ($available_langs as $ilang) {
            if ($ilang != $currLang) {
                $userMenuDropDown->addChild($ilang, array(
                    'route' => 'change_lang',
                    'routeParameters' => array('newlang' => $ilang)));
            }
        }

        return $rightMenu;
    }
}