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
        $menu->addChild('Страницы сайта', ['route' => 'admin-pages', 'attributes' => ['title' => 'Страницы сайта']]);
        $menu->addChild('Галерея', ['uri' => 'javascript:'])
            ->addChild('разделы', ['route' => 'admin-gallery-sections', 'attributes' => ['title' => 'Разделы галереи']]);

        $blog = $menu->addChild('Блог', ['uri' => 'javascript:']);
        $blog->addChild('темы', ['route' => 'admin-blog-themes', 'attributes' => ['title' => 'Темы блога']]);
        $blog->addChild('статьи', ['route' => 'admin-blog-articles', 'attributes' => ['title' => 'Темы блога']]);
        $blog->addChild('добавить', ['route' => 'admin-add-article', 'attributes' => ['title' => 'Темы блога']]);
        $blog->addChild('коментарии', ['route' => 'admin-blog-comments', 'attributes' => ['title' => 'Темы блога']]);

        $menu->addChild('Выйти', ['route' => 'app_logout', 'attributes' => ['title' => 'Выйти']]);

        return $menu;
    }
}
