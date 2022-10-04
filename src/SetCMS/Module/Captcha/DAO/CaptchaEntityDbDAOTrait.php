<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\DAO;

use SetCMS\Module\Captcha\Mapper\CaptchaEntityDbMapper;
use SetCMS\Module\Captcha\CaptchaConstants;

trait CaptchaEntityDbDAOTrait
{

    use \SetCMS\DITrait;
    use \SetCMS\Database\MainConnectionTrait;
    use \SetCMS\FactoryTrait;

    protected function table(): string
    {
        return CaptchaConstants::TABLE_NAME;
    }

    protected function mapper(): CaptchaEntityDbMapper
    {
        return CaptchaEntityDbMapper::make($this->factory());
    }

}
