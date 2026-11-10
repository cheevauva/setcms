<?php

declare(strict_types=1);

namespace Module\Menu\Mapper;

class MenuSlugFromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) string $slug;

    #[\Override]
    protected function run(): void
    {
        $this->slug = $this->validationParams()->string('slug')->notQuiet()->val();
    }
}
