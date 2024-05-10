<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Scope;

use SetCMS\Module\Captcha\CaptchaEntity;
use SetCMS\Module\Captcha\Servant\CaptchaCreateAsPngServant;
use SetCMS\Module\Captcha\DAO\CaptchaSaveDAO;
use SetCMS\UUID;

class CaptchaGenerateScope extends \SetCMS\Scope
{

    private ?CaptchaEntity $captcha;
    private ?string $content = null;

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof CaptchaCreateAsPngServant) {
            $this->content = base64_encode($object->png);
            $this->captcha = $object->captcha;
        }
    }

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CaptchaSaveDAO) {
            $object->captcha = $this->captcha;
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->captcha->id,
            'content' => $this->content,
        ];
    }

}
