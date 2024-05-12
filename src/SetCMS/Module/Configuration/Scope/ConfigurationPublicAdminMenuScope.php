<?php

declare(strict_types=1);

namespace SetCMS\Module\Configuration\Scope;

use SetCMS\Scope;

class ConfigurationPublicAdminMenuScope extends Scope
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
                    'label' => 'Блоки',
                    'name' => 'Block',
                ],
            ]
        ];
    }

}
