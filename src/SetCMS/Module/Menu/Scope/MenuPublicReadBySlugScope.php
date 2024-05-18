<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Scope;

use SetCMS\Attribute\Http\Parameter\Attributes;

class MenuPublicReadBySlugScope extends \SetCMS\Scope
{

    #[Attributes('slug')]
    public string $slug;

}
