<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;

use SetCMS\Controller;
use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageRetrieveBySlugDAO;
use SetCMS\Attribute\Http\Parameter\Attributes;

class PagePublicReadBlockScope extends Controller
{

    protected ?PageEntity $entity = null;

    #[Attributes('slug')]
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
