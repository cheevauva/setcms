<?php

declare(strict_types=1);

namespace Module\Captcha\DAO;

use Module\Captcha\Mapper\CaptchaToRowMapper;

class CaptchaUpdateDAO extends \SetCMS\Entity\DAO\EntityUpdateDAO
{

    use \Module\Captcha\Traits\CaptchaDbalDAOTrait;

    #[\Override]
    protected function row(): array
    {
        return CaptchaToRowMapper::call($this, $this->entity)->row;
    }
}
