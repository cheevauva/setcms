<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use \Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Post\Scope\PostDeleteForm;
use SetCMS\Module\Post\Scope\PostPrivateReadScope;
use SetCMS\Module\Post\Scope\PostPrivateSaveScope;
use SetCMS\Module\Post\Scope\PostPrivateEditScope;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveByIdDAO;
use SetCMS\Module\Post\Servant\PostEntitySaveServant;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveManyByCriteriaDAO;
use SetCMS\Module\Post\Scope\PostPrivateIndexScope;

class PostPrivateController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(PostPrivateIndexScope $form, PostEntityDbRetrieveManyByCriteriaDAO $servant): PostPrivateIndexScope
    {
        return $this->serve($servant, $form);
    }

    public function read(ServerRequestInterface $request, PostPrivateReadScope $form, PostEntityDbRetrieveByIdDAO $servant): PostPrivateReadScope
    {
        return $this->serve($servant, $form, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function new(PostPrivateEditScope $form): PostPrivateEditScope
    {
        return $form;
    }

    public function edit(ServerRequestInterface $request, PostPrivateEditScope $form, PostEntityDbRetrieveByIdDAO $servant): PostPrivateEditScope
    {
        return $this->serve($servant, $form, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function save(ServerRequestInterface $request, PostPrivateSaveScope $form, PostEntitySaveServant $servant): PostPrivateSaveScope
    {
        $servant->id = $request->getAttribute('id');

        return $this->serve($servant, $form, $request->getParsedBody());
    }

    public function delete(ServerRequestInterface $request, PostDeleteForm $form, PostEntitySaveServant $servant): PostDeleteForm
    {
        $servant->id = $request->getAttribute('id');

        return $this->serve($servant, $form);
    }

}
