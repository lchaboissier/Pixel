<?php 

namespace App\EventSubscriber;

use App\Entity\Login;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;

class LoginSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            AuthenticationEvents::AUTHENTICATION_SUCCESS => 'onAuthenticationSuccess',
            // 'onAuthenticationSuccess' est le nom de la méthode à appeler lors de l'événement
        ];
    }

    public function __construct(private EntityManagerInterface $em) 
    {}

    public function onAuthenticationSuccess(AuthenticationEvent $event): void 
    {
        // Récupére l'utilisateur qui vient de se connecter
        $user = $event->getAuthenticationToken()->getUser();

        $login = (new Login)
            ->setUser($user)
            ->setDate(new \DateTime())
        ;

        $this->em->persist($login);
        $this->em->flush();
    }
}