<?php

declare(strict_types=1);

namespace Module\Template\Servant;

use Module\Template\DAO\TemplateRetrieveManyByCriteriaDAO;
use Module\Template\Entity\TemplateEntity;
use Module\Template\VO\TemplateRenderedVO;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\TwigFunction;
use SetCMS\Router\Router;

abstract class TemplateRenderServant extends \UUA\Servant
{
    use \UUA\Traits\EnvTrait;
    use \SetCMS\Traits\TraitsRouter;

    protected string $slug;
    public TemplateRenderedVO $templateRendered;

    #[\Override]
    protected function run(): void
    {
        $entity = $this->entity();

        $templateRendered = new TemplateRenderedVO();
        $templateRendered->title = $this->twig($entity->title, get_object_vars($this));
        $templateRendered->content = $this->twig($entity->entity, get_object_vars($this));

        $this->templateRendered = $templateRendered;
    }

    /**
     * @param string $entity
     * @param array<string, mixed> $context
     * @return string
     */
    protected function twig(string $entity, array $context = []): string
    {
        $twig = (new Environment(...[
            new ArrayLoader([
                'entity' => $entity,
            ]),
            [
                'cache' => false
            ]
        ]));

        $twig->addFunction(new TwigFunction('url', function (string $route, array $params = [], array|string $query = []) {
            $link = $this->router()->generate($route, $params);

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

        return $twig->render('entity', $context);
    }

    protected function entity(): TemplateEntity
    {
        $templateByAlias = TemplateRetrieveManyByCriteriaDAO::new($this);
        $templateByAlias->slug = $this->slug;
        $templateByAlias->limit = 1;
        $templateByAlias->expectOne = true;
        $templateByAlias->allowEmptyResult = false;
        $templateByAlias->serve();

        return $templateByAlias->entity;
    }
}
