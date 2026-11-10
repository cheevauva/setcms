<?php

declare(strict_types=1);

namespace Module\Page\Mapper;

class PageSlugFromRequest extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) string $slug;

    #[\Override]
    protected function run(): void
    {
        $this->slug = $this->validationParams()->string('slug')->notEmpty()->notQuiet()->val();
    }
}
