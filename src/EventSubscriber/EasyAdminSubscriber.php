<?php
namespace App\EventSubscriber;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    
        public static function getSubscribedEvents()
        {
            return[
                    BeforeEntityPersistedEvent::class=> ['setIllustration'],
    
    
            ];
        }
    
        public function setIllustration( BeforeEntityPersistedEvent $event){
            $entity = $event->getEntityInstance();
        }
    
}
