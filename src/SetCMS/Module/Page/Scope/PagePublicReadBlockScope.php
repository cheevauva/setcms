<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;

use SetCMS\Scope;
use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageRetrieveBySlugDAO;
use SetCMS\Contract\Twigable;

class PagePublicReadBlockScope extends Scope implements Twigable
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
