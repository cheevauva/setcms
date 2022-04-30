<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use \Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Post\Form\PostDeleteForm;
use SetCMS\Module\Post\Form\PostSaveForm;
use SetCMS\Module\Post\Form\PostReadForm;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveByIdDAO;
use SetCMS\Module\Post\Servant\PostEntitySaveServant;
use SetCMS\Module\Post\Form\PostIndexForm;

class PostAdminController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(PostIndexForm $form): PostIndexForm
    {
        $form->valid();
        return $form;
    }

    public function read(ServerRequestInterface $request, PostReadForm $form, PostEntityDbRetrieveByIdDAO $servant): PostReadForm
    {
        return $this->serve($servant, $form, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function save(ServerRequestInterface $request, PostSaveForm $form, PostEntitySaveServant $servant): PostSaveForm
    {
        $servant->id = $request->getAttribute('id');

        return $this->serve($servant, $form, $request->getParsedBody());
    }

    public function delete(ServerRequestInterface $request, PostDeleteForm $form, PostEntitySaveServant $servant): PostDeleteForm
    {
        return $this->serve($servant, $form, [
            'id' => $request->getAttribute('id'),
        ]);
    }

}
