<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Scope;

use SetCMS\Scope;

class MenuPublicAdminMenuScope extends Scope
{

    public function toArray(): array
    {
        return [
            'modules' => [
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
            ]
        ];
    }

}
