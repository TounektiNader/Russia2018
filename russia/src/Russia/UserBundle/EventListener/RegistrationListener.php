<?php
/**
 * Created by PhpStorm.
 * User: Nader
 * Date: 14/03/2018
 * Time: 23:07
 */

namespace Russia\UserBundle\EventListener;
use FOS\UserBundle\FOSUserEvents;

use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class RegistrationListener implements  EventSubscriberInterface
{
    public static function  getSubscribedEvents()
    {
         return array(
             FOSUserEvents::REGISTRATION_SUCCESS=>'onRegistrationSuccess'


    );
    }

    public function onRegistrationSuccess(FormEvent $event){
        $roles=array();
        $user=$event->getForm()->getData();
        $user->setRoles($roles);
        $user->setRole('Utilisateur');



    }

}