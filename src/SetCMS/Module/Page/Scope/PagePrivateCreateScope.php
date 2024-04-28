<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;

use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageSaveDAO;

class PagePrivateCreateScope extends PagePrivateScope
{

    protected ?PageEntity $entity = null;
    public PagePrivatePageScope $page;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageSaveDAO) {
            $this->entity = new PageEntity;
            $this->page->to($this->entity);
            $object->page = $this->entity;
        }
    }

    public function toArray(): array
    {
        return [
            'page' => $this->entity,
        ];
    }

}
