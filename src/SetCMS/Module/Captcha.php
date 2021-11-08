<?php

namespace SetCMS\Module;

use SetCMS\Module\Module as Module;
use SetCMS\Module\Modules\Contract\ModuleIndexInterface;
use SetCMS\Module\Captcha\CaptchaIndex;

class Captcha extends Module implements ModuleIndexInterface
{

    public function getIndexControllerClassName(): string
    {
        return CaptchaIndex::class;
    }

}
