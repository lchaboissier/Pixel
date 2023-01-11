<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Security;

final class Builder
{
    public function __construct(private FactoryInterface $factory, private Security $security)
    {

    }

    public function mainMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Home', ['route' => 'app_app_homepage']);

        return $menu;
    }

    public function userMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        if ($this->security->isGranted('ROLE_USER')) {
            $menu->addChild('security.logout', ['route' => 'app_logout']);
        } else {
            $menu->addChild('security.register', ['route' => 'app_register']);
            $menu->addChild('security.login', ['route' => 'app_login']);
        }

        return $menu;
    }

    public function adminMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('game.games', ['route' => 'app_game_admin']);
        $menu->addChild('editor.editors', ['route' => 'app_editor_index']);
        $menu->addChild('support.supports', ['route' => 'app_support_index']);

        return $menu;
    }
}