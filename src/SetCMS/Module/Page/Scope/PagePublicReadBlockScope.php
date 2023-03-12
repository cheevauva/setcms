<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;

use SetCMS\Scope;
use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageRetrieveBySlugDAO;

class PagePublicReadBlockScope extends Scope
{

    protected ?PageEntity $entity = null;
    public string $slug;

    public function to(object $object): void
    {
        if ($object instanceof PageRetrieveBySlugDAO) {
            $object->slug = $this->slug;
        }
    }

    public function from(object $object): void
    {
        if ($object instanceof PageRetrieveBySlugDAO) {
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
