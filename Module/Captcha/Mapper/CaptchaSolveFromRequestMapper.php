<?php

declare(strict_types=1);

namespace Module\Captcha\Mapper;

use SetCMS\UUID;

class CaptchaSolveFromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) string $solvedText;
    public protected(set) UUID $id;

    #[\Override]
    public function serve(): void
    {
        $body = $this->validationBody();

        $this->solvedText = $body->string('solvedText')->notEmpty()->val();
        $this->id = $body->uuid('id')->notEmpty()->val();
    }
}
