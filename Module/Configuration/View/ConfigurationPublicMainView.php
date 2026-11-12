<?php

declare(strict_types=1);

namespace Module\Configuration\View;

class ConfigurationPublicMainView extends \SetCMS\View\ViewJson
{

    public string $name1 = 'SetCMS';
    public string $title = 'SetCMS';
    public string $description = 'SetCMS - система управления сайтом';
    public string $keywords = 'cms, setcms, setcms4, система управления сайтом';
    public bool $showMainPage = true;
    public string $mainPagePath = 'Home';
    public string $mainPageLabel = 'Главная';
    public string $theme = 'bootstrap5';
}
