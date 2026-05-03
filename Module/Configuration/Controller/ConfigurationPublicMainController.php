<?php

declare(strict_types=1);

namespace Module\Configuration\Controller;

use SetCMS\Controller\ControllerViaPSR7;

class ConfigurationPublicMainController extends ControllerViaPSR7
{

    public string $name1 = 'SetCMS';
    public string $title = 'SetCMS';
    public string $description = 'SetCMS - система управления сайтом';
    public string $keywords = 'cms, setcms, setcms4, система управления сайтом';
    public bool $main_page_show = true;
    public string $main_page_path = 'Home';
    public string $main_page_label = 'Главная';
}
