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
    public function createMainMenu(): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $menu->addChild('Главная', ['route' => 'index', 'attributes' => ['title' => 'Главная']]);
        $menu->addChild('Конкурсы для детей', ['route' => 'new-order-kid', 'attributes' => ['title' => 'Конкурсы для детей']]);
        $menu->addChild('Конкурсы для педагогов', ['route' => 'new-order-educator', 'attributes' => ['title' => 'Конкурсы для педагогов']]);
        $menu->addChild('Статьи', ['route' => 'articles', 'attributes' => ['title' => 'Статьи']]);
        $menu->addChild('Образцы дипломов', ['route' => 'diploma', 'attributes' => ['title' => 'Образцы дипломов']]);
        $menu->addChild('Правила', ['route' => 'rules', 'attributes' => ['title' => 'Правила']]);
        $menu->addChild('Результаты конкурсов', ['route' => 'results', 'attributes' => ['title' => 'Результаты конкурсов']]);
        $menu->addChild('Галерея работ', ['route' => 'gallery', 'attributes' => ['title' => 'Галерея работ']]);
        $menu->addChild('Отзывы о сайте', ['route' => 'reviews', 'attributes' => ['title' => 'Отзывы о сайте']]);
        $menu->addChild('Контакты', ['route' => 'contacts', 'attributes' => ['title' => 'Контакты']]);
        if ($this->security->isGranted('ROLE_USER')) {
            $menu->addChild('Выйти', ['route' => 'app_logout', 'attributes' => ['title' => 'Выйти']]);
        } else {
            $menu->addChild('Войти', ['route' => 'app_login', 'attributes' => ['title' => 'Войти']]);
        }
        $menu->setChildrenAttribute('class', 'dd-menu');

        return $menu;
    }
}
