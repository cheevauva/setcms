<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Scope;

class PostPrivateEditScope extends \SetCMS\Entity\Scope\EntityEditScope implements \SetCMS\Contract\Twigable
{

    public function toArray(): array
    {
        return [
            'post' => $this->entity,
        ];
    }

}
