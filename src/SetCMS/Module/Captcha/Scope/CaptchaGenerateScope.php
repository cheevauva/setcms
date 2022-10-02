<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Scope;

use SetCMS\Module\Captcha\Servant\CaptchaCreateAsPngServant;
use SetCMS\UUID;

class CaptchaGenerateScope extends \SetCMS\Scope
{

    public ?UUID $id = null;
    public ?string $content = null;

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
        ];
    }

    public function from(object $object): void
    {
        parent::from($object);
        
        if ($object instanceof CaptchaCreateAsPngServant) {
            $this->content = base64_encode($object->png);
            $this->id = $object->captcha->id;
        }
    }

}
