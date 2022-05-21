<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;

use SetCMS\Module\Page\DAO\PageEntityDbRetrieveManyByCriteriaDAO;

class PagePrivateIndexScope extends \SetCMS\Scope implements \SetCMS\Contract\Twigable
{

    private ?\Iterator $pages = null;

    public function from(object $object): void
    {
        if ($object instanceof PageEntityDbRetrieveManyByCriteriaDAO) {
            $this->pages = $object->entities;
        }
    }

    public function toArray(): array
    {
        return [
            'pages' => $this->pages,
        ];
    }

}
