<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Menu\View\MenuPrivateAdminMenuView;

class MenuPrivateAdminMenuController extends ControllerViaPSR7
{

    /**
     * @var array<int,array<mixed>>
     */
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
        [
            'label' => 'Шаблоны',
            'name' => 'Template',
        ],
        [
            'label' => 'Модуль01',
            'name' => 'Module01',
        ],
    ];

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            MenuPrivateAdminMenuView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MenuPrivateAdminMenuView) {
            $object->modules = $this->modules;
        }
    }
}
