<?php

namespace SetCMS\Module\Page;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Page\Form\PageReadForm;
use SetCMS\Module\Page\Form\PageSaveForm;
use SetCMS\Module\Page\Form\PageDeleteForm;
use SetCMS\Module\Page\Servant\PageEntitySaveServant;
use SetCMS\Module\Page\DAO\PageEntityDbRetrieveByIdDAO;

class PageAdminController
{

    use \SetCMS\ControllerTrait;

    public function read(ServerRequestInterface $request, PageReadForm $form, PageEntityDbRetrieveByIdDAO $servant): PageReadForm
    {
        return $this->serve($servant, $form, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function save(ServerRequestInterface $request, PageSaveForm $form, PageEntitySaveServant $servant): PageSaveForm
    {
        $servant->id = $request->getAttribute('id');

        return $this->serve($servant, $form, $request->getParsedBody());
    }

    public function delete(ServerRequestInterface $request, PageDeleteForm $form, PageEntitySaveServant $servant): PageDeleteForm
    {
        return $this->serve($servant, $form, [
            'id' => $request->getAttribute('id'),
        ]);
    }

}
