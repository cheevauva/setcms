<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;

use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\Servant\PageEntitySaveServant;
use SetCMS\Module\Page\DAO\PageEntityDbRetrieveByIdDAO;

class PagePrivateSaveScope extends \SetCMS\Scope implements \SetCMS\Contract\Applicable
{

    public string $slug;
    public string $content;
    public string $title;
    private ?PageEntity $page = null;

    public function to(object $object): void
    {
        if ($object instanceof PageEntitySaveServant) {
            $object->apply = $this;
        }
    }

    public function from(object $object): void
    {
        if ($object instanceof PageEntityDbRetrieveByIdDAO) {
            $this->page = $object->entity;
        }

        if ($object instanceof PageEntitySaveServant) {
            $this->page = $object->entity;
        }
    }

    public function apply(object $object): void
    {
        if ($object instanceof PageEntity) {
            $object->slug = $this->slug;
            $object->title = $this->title;
            $object->content = $this->content;
        }
    }

    public function toArray(): array
    {
        return [
            'page' => $this->page,
        ];
    }

}
