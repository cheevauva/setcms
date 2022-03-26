<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use SetCMS\Core\Controller;
use \Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Post\Form\PostDeleteForm;
use SetCMS\Module\Post\PostEntityRetrieveByIdDAO;
use SetCMS\Module\Post\PostEntitySaveDAO;

class PostAdminController extends Controller
{

    public function delete(ServerRequestInterface $request, PostDeleteForm $form, PostEntityRetrieveByIdDAO $retrieveEntityById, PostEntitySaveDAO $saveEntity): PostDeleteForm
    {
        return parent::deleteById($request, $form, $retrieveEntityById, $saveEntity);
    }

}
