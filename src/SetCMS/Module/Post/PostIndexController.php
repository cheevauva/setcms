<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Post\Form\PostIndexForm;
use SetCMS\Module\Post\Form\PostReadBySlugForm;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveBySlugDAO;

class PostIndexController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(PostIndexForm $form): PostIndexForm
    {
        $form->valid();
        return $form;
    }

    public function readBySlug(ServerRequestInterface $request, PostReadBySlugForm $form, PostEntityDbRetrieveBySlugDAO $servant): PostReadBySlugForm
    {
        return $this->serve($servant, $form, [
            'slug' => $request->getAttribute('slug'),
        ]);
    }

}
