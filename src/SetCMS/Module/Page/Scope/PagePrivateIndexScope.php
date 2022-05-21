<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;


class PagePrivateIndexScope extends \SetCMS\Entity\Scope\EntityIndexScope implements \SetCMS\Contract\Twigable
{
    public function toArray(): array
    {
        return [
            'pages' => $this->entities,
        ];
    }

}
