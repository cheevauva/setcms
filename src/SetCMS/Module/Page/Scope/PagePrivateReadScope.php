<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;

class PagePrivateReadScope extends \SetCMS\Entity\Scope\EntityReadScope implements \SetCMS\Contract\Twigable
{

    public function toArray(): array
    {
        return [
            'page' => $this->entity,
        ];
    }

}
