<?php

declare(strict_types=1);

namespace SetCMS\Module\Configuration\Controller;

use SetCMS\Controller;
use SetCMS\Attribute\Http\RequestMethod;
use SetCMS\Attribute\ResponderPassProperty;

#[RequestMethod('GET')]
class ConfigurationPublicMainController extends Controller
{

    #[ResponderPassProperty]
    protected string $name = 'SetCMS';

    #[ResponderPassProperty]
    protected string $title = 'SetCMS';

    #[ResponderPassProperty]
    protected string $description = 'SetCMS - система управления сайтом';

    #[ResponderPassProperty]
    protected string $keywords = 'cms, setcms, setcms4, система управления сайтом';

    #[ResponderPassProperty]
    protected bool $main_page_show = true;

    #[ResponderPassProperty]
    protected string $main_page_path = 'home';

    #[ResponderPassProperty]
    protected string $main_page_label = 'Главная';
}
