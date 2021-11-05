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
        [
            'name' => 'OAuthClients',
            'label' => 'OAuth клиенты-приложения',
        ],
    ];
    public string $self;
    public Router $router;
    private array $config = [];

    public function getDefaultKeywords()
    {
        return $this->config['keywords'] ?? '';
    }

    public function getDefaultTitle()
    {
        return $this->config['title'] ?? '';
    }

    public function __construct(array $config, ServerRequestInterface $request, Router $router)
    {
        $this->config = $config;
        $this->theme = $config['theme'];
        $this->router = clone $router;
        $this->router->setBasePath(rtrim($request->getServerParams()['SCRIPT_NAME'], '/'));
        $this->self = $request->getServerParams()['REQUEST_SCHEME'] . '://' . $request->getServerParams()['HTTP_HOST'];
        $this->baseUrl = dirname($request->getServerParams()['SCRIPT_NAME']);

        if (substr($this->baseUrl, -1) !== '/') {
            $this->baseUrl .= '/';
        }
    }

    public function markdown(string $string): string
    {
        $pd = new \Parsedown;
        $pd->setSafeMode(true);

        return $pd->text($string);
    }

    public function link2(string $route, $params = [], $query = ''): string
    {
        return $this->self . $this->link($route, $params, $query);
    }

    public function link(string $route, $params = [], $query = ''): string
    {
        $link = $this->router->generate($route, $params);

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
