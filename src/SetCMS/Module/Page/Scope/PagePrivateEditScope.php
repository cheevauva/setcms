<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;

class PagePrivateEditScope extends \SetCMS\Entity\Scope\EntityEditScope implements \SetCMS\Contract\Twigable
{

    public function toArray(): array
    {
        return [
            'page' => $this->entity,
        ];
    }

}
