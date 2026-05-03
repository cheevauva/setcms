<?php

declare(strict_types=1);

namespace Module\Captcha\View;

use SetCMS\View\ViewJson;
use Module\Captcha\Entity\CaptchaEntity;

class CaptchaPublicSolveView extends ViewJson
{

    public CaptchaEntity $captcha;

    #[\Override]
    protected function data(): array
    {
        $data = parent::data();
        $data['isSolved'] = $this->captcha->isSolved;
        $data['isUsed'] = $this->captcha->isUsed;

        return $data;
    }
}
