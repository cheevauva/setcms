<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use SetCMS\Controller;
use SetCMS\Attribute\ResponderPassProperty;

class MenuPublicAdminMenuController extends Controller
{

    /**
     * @var array<int,array<mixed>>
     */
    #[ResponderPassProperty]
    protected array $modules = [
        [
            'label' => 'Посты',
            'name' => 'Post',
        ],
        [
            'label' => 'Страницы',
            'name' => 'Page',
        ],
        [
            'label' => 'Пользователи',
            'name' => 'User',
        ],
        [
            'label' => 'Меню',
            'name' => 'Menu',
        ],
    ];
}
