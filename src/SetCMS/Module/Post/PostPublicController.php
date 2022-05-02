<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Post\Form\PostIndexForm;
use SetCMS\Module\Post\Form\PostReadBySlugForm;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveBySlugDAO;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveManyByCriteriaDAO;

class PostPublicController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(PostIndexForm $form, PostEntityDbRetrieveManyByCriteriaDAO $servant): PostIndexForm
    {
        return $this->serve($servant, $form, []);
    }

    public function readBySlug(ServerRequestInterface $request, PostReadBySlugForm $form, PostEntityDbRetrieveBySlugDAO $servant): PostReadBySlugForm
    {
        return $this->serve($servant, $form, [
            'slug' => $request->getAttribute('slug'),
        ]);
    }

}
