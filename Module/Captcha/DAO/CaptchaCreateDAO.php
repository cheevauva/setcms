<?php

declare(strict_types=1);

namespace Module\Captcha\DAO;

use Module\Captcha\Mapper\CaptchaToRowMapper;

class CaptchaCreateDAO extends \UUA\DAO
{

    use \SetCMS\DAO\DAOEntityCreateTrait;
    use \Module\Captcha\Traits\CaptchaDbalDAOTrait;
    use \Module\Captcha\Traits\CaptchaCallTrait;

    #[\Override]
    protected function row(): array
    {
        return CaptchaToRowMapper::call($this->container, $this->captcha)->row;
    }
}
