<?php

declare(strict_types=1);

namespace Module\Captcha\DAO;

use Module\Captcha\Mapper\CaptchaToRowMapper;
use Module\Captcha\Entity\CaptchaEntity;
use SetCMS\Entity\DAO\EntityCreateDAO;

/**
 * @property CaptchaEntity $entity
 */
class CaptchaCreateDAO extends EntityCreateDAO
{

    use \Module\Captcha\Traits\CaptchaDbalDAOTrait;

    #[\Override]
    protected function row(): array
    {
        return CaptchaToRowMapper::call($this, $this->entity)->row;
    }
}
