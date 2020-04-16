<?php


namespace App\Menu;


use App\Entity\GalleryCategory;
use App\Entity\GameRoomCategory;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class MainMenu
{
    private $factory;
    private $doctrine;

    public function __construct(FactoryInterface $factory, ContainerInterface $container)
    {
        $this->factory = $factory;
        $this->doctrine = $container->get('doctrine');
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
        $gallery = $menu->addChild('Фотогалерея', ['route' => 'gallery', 'attributes' => ['title' => 'Фотогалерея']]);
        $this->addGalleryChildren($gallery);
        $gameRoom = $menu->addChild('Игровая', ['route' => 'game-room', 'attributes' => ['title' => 'Игровая']]);
        $this->addGameRoomCategories($gameRoom);
        $menu->addChild('Контакты', ['route' => 'contacts', 'attributes' => ['title' => 'Контакты']]);
        $menu->setChildrenAttribute('class', 'dd-menu');



        return $menu;
    }

    private function addGalleryChildren(ItemInterface &$gallery)
    {
        $galleryCategoryRepository = $this->doctrine->getRepository(GalleryCategory::class);
        $categories = $galleryCategoryRepository->findBy(['active' => 'yes']);
        /** @var GalleryCategory $category */
        foreach ($categories as $category) {
            $gallery->addChild(
                $category->getTitle(),
                [
                    'route' => 'gallery-category',
                    'routeParameters' => ['id' => $category->getId()],
                    'attributes' => ['title' => $category->getTitle()],
                ]
            );
        }
    }

    private function addGameRoomCategories(ItemInterface &$gameRoom)
    {
        $gameRoomCategoryRepository = $this->doctrine->getRepository(GameRoomCategory::class);
        $categories = $gameRoomCategoryRepository->findBy(['active' => 'yes']);
        /** @var GameRoomCategory $category */
        foreach ($categories as $category) {
            $gameRoom->addChild(
                $category->getTitle(),
                [
                    'route' => 'game-room-category',
                    'routeParameters' => ['id' => $category->getId()],
                    'attributes' => ['title' => $category->getTitle()],
                ]
            );
        }
    }
}
