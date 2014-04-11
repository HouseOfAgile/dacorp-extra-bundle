<?php
namespace Dacorp\ExtraBundle\Listener;
use Aaa\Bundle\CoreBundle\Entity\AsmUser;
use Dacorp\ExtraBundle\DacorpExtraEvents;
use Dacorp\ExtraBundle\Event\LangPreferenceEvent;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\SecurityContext;

class PreferenceListener implements EventSubscriberInterface
{
    private $security;
    private $em;

    public function __construct(SecurityContext $security, EntityManager $em)
    {
        $this->security = $security;
        $this->em = $em;

    }

    public static function getSubscribedEvents()
    {
        return array(
            DacorpExtraEvents::AUTHENTICATED_USER_CHANGE_LANG => 'updateUserLangPreference',
        );
    }

    public function updateUserLangPreference(LangPreferenceEvent $event)
    {
        /**@var AsmUser $authUser*/
        $authUser= $this->security->getToken()->getUser();
        $authUser->setLocale($event->getPreferredLang());
        $this->em->flush();
    }
}