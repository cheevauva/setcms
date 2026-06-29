<?php

declare(strict_types=1);

namespace Module\Post\Mapper;

class PostSlugFromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) string $slug;

    #[\Override]
    public function serve(): void
    {
        $this->slug = $this->validationParams()->string('slug')->notEmpty()->notQuiet()->val();
    }
}
