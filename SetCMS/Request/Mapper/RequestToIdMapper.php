<?php

declare(strict_types=1);

namespace SetCMS\Request\Mapper;

use SetCMS\UUID;

class RequestToIdMapper extends RequestMapper
{

    public protected(set) UUID $id;

    #[\Override]
    protected function run(): void
    {
        $this->id = $this->validationParams()->uuid('id')->notEmpty()->notQuiet()->val();
    }
}
