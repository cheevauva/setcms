<?php

declare(strict_types=1);

namespace Module\User\Mapper;

use SetCMS\UUID;

class UserTokenFromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) UUID $token;

    #[\Override]
    public function serve(): void
    {
        $this->token = $this->validationCookie()->uuid('X-CSRF-Token')->notEmpty()->notQuiet()->val();
    }
}
