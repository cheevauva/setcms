<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Scope;

use SetCMS\Contract\Twigable;

class PostIndexScope extends \SetCMS\Entity\Scope\EntityIndexScope implements Twigable
{

    public function toArray(): array
    {
        return [
            'posts' => $this->entities,
        ];
    }

}
