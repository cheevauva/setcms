<?php

declare(strict_types=1);

namespace SetCMS\Module\Configuration\Scope;

use SetCMS\Scope;

class ConfigurationPublicMainScope extends Scope
{

    public function toArray(): array
    {
        return [
            'name' => 'SetCMS',
            'title' => 'SetCMS',
            'description' => 'SetCMS - система управления сайтом',
            'keywords' => 'cms, setcms, setcms4, система управления сайтом',
            'main_page_show' => true,
            'main_page_path' => 'home',
            'main_page_label' => 'Главная',
        ];
    }

}
