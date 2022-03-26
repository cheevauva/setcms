<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Core\Controller;
use SetCMS\Module\Post\Form\PostForm;
use SetCMS\Module\Post\PostEntityRetrieveBySlugDAO;

class PostIndexController extends Controller
{

    public function index(ServerRequestInterface $request, PostForm $form): PostForm
    {
        return $form;
    }

    public function readBySlug(ServerRequestInterface $request, PostForm $form, PostEntityRetrieveBySlugDAO $retrieveBySlug): PostForm
    {
        throw new \Exception('z');

        $params = $request->getQueryParams();
        $params['slug'] = $request->getAttribute('id') ?? null;

        $form->fromArray($params);

        return parent::readByCriteria($form, $retrieveBySlug);
    }

}
