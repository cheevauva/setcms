<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;

use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageEntityDbRetrieveByIdDAO;

class PagePrivateReadScope extends \SetCMS\Scope implements \SetCMS\Contract\Twigable
{

    public string $id;
    private ?PageEntity $page = null;

    public function to(object $object): void
    {
        if ($object instanceof PageEntityDbRetrieveByIdDAO) {
            $object->id = $this->id;
        }
    }

    public function from(object $object): void
    {
        if ($object instanceof PageEntityDbRetrieveByIdDAO) {
            $this->page = $object->entity;
        }
    }

    public function toArray(): array
    {
        return [
            'page' => $this->page,
        ];
    }

}
