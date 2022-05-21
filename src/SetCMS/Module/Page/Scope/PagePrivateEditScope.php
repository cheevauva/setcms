<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;

use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageEntityDbRetrieveByIdDAO;

class PagePrivateEditScope extends \SetCMS\Scope implements \SetCMS\Contract\Twigable
{

    private ?PageEntity $page = null;

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
