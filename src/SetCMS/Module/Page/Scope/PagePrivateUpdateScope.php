<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;

use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageRetrieveByIdDAO;
use SetCMS\Module\Page\DAO\PageSaveDAO;
use SetCMS\Attribute\Http\Parameter\Body;

class PagePrivateUpdateScope extends PagePrivateScope
{

    protected ?PageEntity $entity = null;

    #[Body('page')]
    public PagePrivatePageScope $page;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageRetrieveByIdDAO) {
            $object->id = $this->page->id;
            $object->throwExceptionIfNotFound = true;
        }

        if ($object instanceof PageSaveDAO) {
            $this->entity = new PageEntity;
            $this->page->to($this->entity);
            $object->page = $this->entity;
        }
    }

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PageRetrieveByIdDAO) {
            $this->entity = $object->page;
        }
    }

    public function toArray(): array
    {
        return [
            'page' => $this->entity,
        ];
    }

}
