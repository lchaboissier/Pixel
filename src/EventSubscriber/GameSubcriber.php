<?php 

namespace App\EventSubscriber;

use App\Event\GameEvent;
use App\Event\GameEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class GameSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array 
    {
        return [
            GameEvents::GAME_ADDED => 'onGameAdded',
        ];
    }

    public function __construct(private MailerInterface $mailer)
    {   
    }

    public function onGameAdded(GameEvent $event): void 
    {
        $game = $event->getGame();

        $mail = (new Email())
            ->to(new Address('admin@test.fr', 'Administrateur'))
            ->subject('Un nouveau jeu a été ajouté')
            ->from(new Address('noreply@test.fr', 'Pixel'))
            ->html("Nouveau jeu ajouté ". $game->getTitle())
        ;

        $this->mailer->send($mail);
    }
}