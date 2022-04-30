<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Post\Form\PostIndexForm;
use SetCMS\Module\Post\Form\PostReadBySlugForm;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveBySlugDAO;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveManyByCriteriaDAO;
use SetCMS\Module\Post\DAO\PostEntityDbSaveDAO;

class PostPublicController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(PostIndexForm $form, PostEntityDbRetrieveManyByCriteriaDAO $servant): PostIndexForm
    {
        $form = $this->serve($servant, $form, []);
        return $form;
    }

    public function readBySlug(ServerRequestInterface $request, PostReadBySlugForm $form, PostEntityDbRetrieveBySlugDAO $servant): PostReadBySlugForm
    {
        return $this->serve($servant, $form, [
            'slug' => $request->getAttribute('slug'),
        ]);
    }

    public function new(PostEntityDbSaveDAO $servant)
    {
        $post = new PostEntity;
        $post->message = sprintf('Cообщение написанное в %s', date('Y-m-d H:i:s'));
        $post->slug = date('YmdHis');
        $post->title = $post->message;
        
        $servant->entity = $post;
        $servant->serve();
    }

}
