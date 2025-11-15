<?php

declare(strict_types=1);

namespace Module\Template\Servant;

use Module\Template\DAO\TemplateRetrieveManyByCriteriaDAO;
use Module\Template\Entity\TemplateEntity;
use Module\Template\VO\TemplateRenderedVO;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\TwigFunction;
use SetCMS\Application\Router\Router;

abstract class TemplateRenderServant extends \UUA\Servant
{
    use \UUA\Traits\EnvTrait;

    protected string $slug;
    public TemplateRenderedVO $templateRendered;

    #[\Override]
    public function serve(): void
    {
        $template = $this->template();

        $templateRendered = new TemplateRenderedVO();
        $templateRendered->title = $this->twig($template->title, get_object_vars($this));
        $templateRendered->content = $this->twig($template->template, get_object_vars($this));

        $this->templateRendered = $templateRendered;
    }

    /**
     * @param string $template
     * @param array<string, mixed> $context
     * @return string
     */
    protected function twig(string $template, array $context = []): string
    {
        $twig = (new Environment(...[
            new ArrayLoader([
                'template' => $template,
            ]),
            [
                'cache' => false
            ]
        ]));

        $twig->addFunction(new TwigFunction('scLink', function (string $route, array $params = [], array|string $query = []) {
            $link = Router::singleton($this->container)->generate($route, $params);

            if ($query && is_string($query)) {
                $link .= '?' . $query;
            }

            if ($query && is_array($query)) {
                $link .= '?' . http_build_query($query);
            }

            return $link;
        }));
        $twig->addFunction(new TwigFunction('scBaseUrl', function () {
            return $this->env()['BASE_URL'] ?? '';
        }));

        return $twig->render('template', $context);
    }

    protected function template(): TemplateEntity
    {
        $templateByAlias = TemplateRetrieveManyByCriteriaDAO::new($this->container);
        $templateByAlias->slug = $this->slug;
        $templateByAlias->limit = 1;
        $templateByAlias->orThrow = true;
        $templateByAlias->serve();

        return TemplateEntity::as($templateByAlias->template);
    }
}
