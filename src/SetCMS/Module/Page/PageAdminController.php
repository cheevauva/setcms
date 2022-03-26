<?php

namespace SetCMS\Module\Page;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Page\Form\PageForm;
use SetCMS\Core\Controller;

class PageAdminController extends Controller
{

    public function read(ServerRequestInterface $request, PageForm $form, PageEntityRetrieveByIdDAO $retrieveEntityById): PageForm
    {
        return parent::readByCriteria($request, $form, $retrieveEntityById);
    }

    public function save(ServerRequestInterface $request, PageForm $form, PageEntityRetrieveByIdDAO $retrieveEntityById, PageEntitySaveDAO $saveEntity, PageEntity $page): PageForm
    {
        return parent::saveById($request, $form, $retrieveEntityById, $saveEntity, $page);
    }

}
