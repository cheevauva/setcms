<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Scope;

use SetCMS\Module\Captcha\Servant\CaptchaResolveServant;
use SetCMS\Module\Captcha\CaptchaEntity;
use SetCMS\UUID;

class CaptchaSolveScope extends \SetCMS\Scope
{

    public UUID $id;
    public string $solvedText;
    private ?CaptchaEntity $captcha = null;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CaptchaResolveServant) {
            $object->id = $this->id;
            $object->solvedText = $this->solvedText;
        }
    }

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof CaptchaResolveServant) {
            $this->captcha = $object->captcha;
        }
    }

    public function toArray(): array
    {
        if (!$this->captcha) {
            return [];
        }

        return [
            'isSolved' => $this->captcha->isSolved,
            'isUsed' => $this->captcha->isUsed,
        ];
    }

}
