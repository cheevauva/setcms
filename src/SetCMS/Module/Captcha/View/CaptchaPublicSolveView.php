<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\View;

use SetCMS\View\ViewJson;
use SetCMS\Module\Captcha\CaptchaEntity;

class CaptchaPublicSolveView extends ViewJson
{

    public ?CaptchaEntity $captcha = null;

    #[\Override]
    protected function data(): array
    {
        $data = [];

        if (!$this->captcha) {
            return [];
        }
        
        $data['isSolved'] = $this->captcha->isSolved;
        $data['isUsed'] = $this->captcha->isUsed;

        return $data;
    }
}
