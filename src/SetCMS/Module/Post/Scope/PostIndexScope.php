<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Scope;


class PostIndexScope extends \SetCMS\Entity\Scope\EntityIndexScope implements \SetCMS\Contract\Twigable, \SetCMS\Contract\Protectable
{

    public function toArray(): array
    {
        return [
            'posts' => $this->entities,
        ];
    }

}
