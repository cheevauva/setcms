<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use \Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Post\Form\PostDeleteForm;
use SetCMS\Module\Post\Form\PostPrivateReadForm;
use SetCMS\Module\Post\Form\PostPrivateSaveForm;
use SetCMS\Module\Post\Form\PostPrivateEditForm;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveByIdDAO;
use SetCMS\Module\Post\Servant\PostEntitySaveServant;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveManyByCriteriaDAO;
use SetCMS\Module\Post\Form\PostPrivateIndexForm;

class PostPrivateController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(PostPrivateIndexForm $form, PostEntityDbRetrieveManyByCriteriaDAO $servant): PostPrivateIndexForm
    {
        return $this->serve($servant, $form, []);
    }

    public function read(ServerRequestInterface $request, PostPrivateReadForm $form, PostEntityDbRetrieveByIdDAO $servant): PostPrivateReadForm
    {
        $servant->id = $request->getAttribute('id');
        
        return $this->serve($servant, $form);
    }

    public function new(PostPrivateEditForm $form): PostPrivateEditForm
    {
        return $form;
    }

    public function edit(ServerRequestInterface $request, PostPrivateEditForm $form, PostEntityDbRetrieveByIdDAO $servant): PostPrivateEditForm
    {
        $servant->id = $request->getAttribute('id');

        return $this->serve($servant, $form);
    }

    public function save(ServerRequestInterface $request, PostPrivateSaveForm $form, PostEntitySaveServant $servant): PostPrivateSaveForm
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
