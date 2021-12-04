<?php

namespace SetCMS\Responder;

use Psr\Container\ContainerInterface as Container;
use SetCMS\Module\Themes\ThemeDAO;
use SetCMS\Router as Router;
use SetCMS\Module\Modules\ModuleDAO;

class Html extends Responder
{

    protected \Twig\Environment $twig;
    protected string $basePath;
    protected ThemeDAO $themeDAO;
    protected array $config;
    protected Router $router;
    protected ModuleDAO $moduleDAO;
    public string $template;

    public function __construct(Container $container)
    {
        $this->basePath = $container->get('basePath');
        $this->themeDAO = $container->get(ThemeDAO::class);
        $this->config = $container->get('config');
        $this->router = $container->get(Router::class);
        $this->moduleDAO = $container->get(ModuleDAO::class);
    }

    protected function getTwig(): ?\Twig\Environment
    {
        if (!empty($this->twig)) {
            return $this->twig;
        }

        $loader = new \Twig\Loader\FilesystemLoader($this->basePath . '/resources/templates');
        $twig = new \Twig\Environment($loader, [
            'cache' => $this->basePath . '/cache/twig',
            'auto_reload' => true,
        ]);

        $theme = $this->themeDAO->get($this->config['theme']);
        $theme->config = $this->config;
        $theme->setRouter($this->router);
        $theme->setRequest($this->request);
        $theme->setModuleFinder($this->moduleDAO);
        $theme->currentModule = $this->request->getAttribute('module');
        $theme->currentUser = $this->request->getAttribute('user');

        $twig->addGlobal('setcms', $theme);
        $twig->addFunction(new \Twig\TwigFunction('render', function ($template, $params = []) {
            $request = $this->withAttributes($this->request, $params);
            $model = (new Action($request))();
            $content = $this->getTwig()->render($template, $model->toArray());

            return new \Twig\Markup($content, 'UTF-8');
        }));

        return $this->twig = $twig;
    }

    protected function getContentType(): string
    {
        return 'text/html';
    }

    protected function getContent(): string
    {
        return $this->getTwig()->render(sprintf('themes/%s/%s', $this->config['theme'], $this->template), $this->model->toArray());
    }

}
