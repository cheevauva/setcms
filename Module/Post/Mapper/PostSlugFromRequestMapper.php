<?php

declare(strict_types=1);

namespace Module\Post\Mapper;

class PostSlugFromRequestMapper extends \SetCMS\Mapper\MapperFromRequest
{

    public string $slug;

    #[\Override]
    public function serve(): void
    {
        $this->slug = $this->validationParams()->string('slug')->notEmpty()->notQuiet()->val();
    }
}
