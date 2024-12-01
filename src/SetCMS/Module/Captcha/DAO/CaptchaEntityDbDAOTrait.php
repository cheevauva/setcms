<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\DAO;

use SetCMS\Module\Captcha\Mapper\CaptchaEntityDbMapper;
use SetCMS\Module\Captcha\CaptchaConstants;

trait CaptchaEntityDbDAOTrait
{

    use \SetCMS\Traits\DITrait;
    use \SetCMS\Traits\DatabaseMainConnectionTrait;
    use \SetCMS\Traits\FactoryTrait;

    protected function table(): string
    {
        return CaptchaConstants::TABLE_NAME;
    }

    protected function mapper(): CaptchaEntityDbMapper
    {
        return CaptchaEntityDbMapper::make($this->factory());
    }

}
