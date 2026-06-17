<?php

declare(strict_types=1);

namespace SetCMS\Mapper;

use SetCMS\UUID;

class MapperIdFromRequest extends MapperFromRequest
{

    public protected(set) UUID $id;

    #[\Override]
    public function serve(): void
    {
        $this->id = $this->validationParams()->uuid('id')->notEmpty()->notQuiet()->val();
    }
}
