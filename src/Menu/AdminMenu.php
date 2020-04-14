<?php


namespace App\Menu;


use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;


class AdminMenu
{
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return ItemInterface
     */
    public function createMenu(): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $menu->addChild('Страницы сайта', ['route' => 'admin', 'attributes' => ['title' => 'Страницы сайта']]);
        $menu->addChild('Картинка в шапке', ['route' => 'admin-main-images', 'attributes' => ['title' => 'Картинка в шапке']]);

        $gallery = $menu->addChild('Галерея', ['uri' => 'javascript:']);
        $gallery->addChild('категории', ['route' => 'admin-gallery-categories', 'attributes' => ['title' => 'Разделы галереи']]);
//        $gallery->addChild('подкатегории', ['route' => 'admin-gallery-subcategories', 'attributes' => ['title' => 'Подразделы галереи']]);

        $blog = $menu->addChild('Блог', ['uri' => 'javascript:']);
        $blog->addChild('добавить', ['route' => 'admin-add-article', 'attributes' => ['title' => 'Темы блога']]);
        $blog->addChild('темы', ['route' => 'admin-blog-themes', 'attributes' => ['title' => 'Темы блога']]);
        $blog->addChild('статьи', ['route' => 'admin-blog-articles', 'attributes' => ['title' => 'Темы блога']]);
        $blog->addChild('коментарии', ['route' => 'admin-blog-comments', 'attributes' => ['title' => 'Темы блога']]);

        $menu->addChild('Выйти', ['route' => 'app_logout', 'attributes' => ['title' => 'Выйти']]);

        return $menu;
    }
}
