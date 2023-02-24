<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;

use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageRetrieveByIdDAO;
use SetCMS\Module\Page\Servant\PageUpdateServant;

class PagePrivateUpdateScope extends PagePrivateScope
{

    protected ?PageEntity $entity = null;
    public PagePrivatePageScope $page;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageRetrieveByIdDAO) {
            $this->entity = new PageEntity;
            $this->page->to($this->entity);
            $object->id = $this->entity->id;
        }

        if ($object instanceof PageUpdateServant) {
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
