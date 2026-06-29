<?php

declare(strict_types=1);

namespace Module\User\Mapper;

use SetCMS\UUID;

class UserRestoreFromRequstMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public bool $useCaptcha = false;
    public protected(set) string $email;
    public protected(set) ?UUID $captcha = null;

    #[\Override]
    public function serve(): void
    {
        $body = $this->validationBody();

        $this->email = $body->string('email')->notEmpty()->val();
        $this->captcha = $this->useCaptcha ? $body->uuid('captcha')->notEmpty()->val() : null;
    }
}
