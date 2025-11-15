<?php

declare(strict_types=1);

namespace Module\Captcha\DAO;

use Module\Captcha\Exception\CaptchaNotFoundException;

class CaptchaRetrieveManyByCriteriaDAO extends \SetCMS\Common\DAO\EntityRetrieveManyByCriteriaDAO
{

    use CaptchaCommonDAO;

    #[\Override]
    protected function notFoundExcecption(): CaptchaNotFoundException
    {
        return new CaptchaNotFoundException();
    }
}
