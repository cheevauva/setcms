<?php

namespace SetCMS;

use SetCMS\Module\Users\User;
use SetCMS\Router;
use Psr\Http\Message\ServerRequestInterface;

class Theme
{

    public string $theme;
    public ?User $currentUser;
    public string $currentModule;
    public string $baseUrl;
    public array $modules = [
        [
            'name' => 'Pages',
            'label' => 'Страницы',
        ],
        [
            'name' => 'Posts',
            'label' => 'Посты',
        ],
        [
            'name' => 'Users',
            'label' => 'Пользователи',
        ],
        [
            'name' => 'Migrations',
            'label' => 'Миграции',
        ],
    ];
    public string $self;
    public Router $router;

    public function __construct(string $theme, ServerRequestInterface $request, Router $router)
    {
        $this->theme = $theme;
        $this->self = $request->getServerParams()['SCRIPT_NAME'];
        $this->router = $router;
    }

    public function markdown(string $string): string
    {
        $pd = new \Parsedown;
        $pd->setSafeMode(true);

        return $pd->text($string);
    }

    public function link(string $route, $params = [], $query = ''): string
    {
        $link = $this->self . $this->router->generate($route, $params);

        if ($query) {
            $link .= '?' . (is_array($query) ? http_build_query($query) : $query);
        }

        return $link;
    }

    public function path(string $path): string
    {
        return sprintf('themes/%s/%s', $this->theme, $path);
    }

    public function render($template, $params = [])
    {
        $request = $this->withAttributes($this->request, $params);
        $model = $this->invokeAction(new Action($request));
        return $this->getTwig()->render($template, $model->toArray());
    }

}
