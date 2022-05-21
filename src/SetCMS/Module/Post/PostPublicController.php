<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Post\Scope\PostIndexScope;
use SetCMS\Module\Post\Scope\PostReadBySlugScope;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveBySlugDAO;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveManyByCriteriaDAO;

class PostPublicController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(PostIndexScope $form, PostEntityDbRetrieveManyByCriteriaDAO $servant): PostIndexScope
    {
        return $this->serve($servant, $form, []);
    }

    public function readBySlug(ServerRequestInterface $request, PostReadBySlugScope $form, PostEntityDbRetrieveBySlugDAO $servant): PostReadBySlugScope
    {
        return $this->serve($servant, $form, [
            'slug' => $request->getAttribute('slug'),
        ]);
    }

}
