<?php

declare(strict_types=1);

namespace SetCMS\Module\Configuration\Controller;

use SetCMS\Controller;

class ConfigurationPublicMainController extends Controller
{

    protected string $name = 'SetCMS';
    protected string $title = 'SetCMS';
    protected string $description = 'SetCMS - система управления сайтом';
    protected string $keywords = 'cms, setcms, setcms4, система управления сайтом';
    protected bool $main_page_show = true;
    protected string $main_page_path = 'home';
    protected string $main_page_label = 'Главная';
}
