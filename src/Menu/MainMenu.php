<?php


namespace App\Menu;


use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class MainMenu
{
    private $factory;
    private $security;

    public function __construct(FactoryInterface $factory, AuthorizationCheckerInterface $security)
    {
        $this->factory = $factory;
        $this->security = $security;
    }

    /**
     * @return ItemInterface
     */
    public function createMenu(): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $menu->addChild('Главная', ['route' => 'index', 'attributes' => ['title' => 'Главная']]);
        $menu->addChild('Обо мне', ['route' => 'about', 'attributes' => ['title' => 'Обо мне']]);
        $menu->addChild('Блог', ['route' => 'blog', 'attributes' => ['title' => 'Блог']]);
        $menu->addChild('Методические разработки', ['route' => 'methodical', 'attributes' => ['title' => 'Методические разработки']]);
        $menu->addChild('Фотогалерея', ['route' => 'gallery', 'attributes' => ['title' => 'Статьи']])
            ->addChild('111', ['route' => 'blog', 'attributes' => ['title' => 'Блог']]);
        $menu->addChild('Контакты', ['route' => 'contacts', 'attributes' => ['title' => 'Контакты']]);
        if ($this->security->isGranted('ROLE_USER')) {
            $menu->addChild('Выйти', ['route' => 'app_logout', 'attributes' => ['title' => 'Выйти']]);
        }
        $menu->setChildrenAttribute('class', 'dd-menu');

        return $menu;
    }
}
