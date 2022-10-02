<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Servant;

class CaptchaCreateAsPngServant extends CaptchaCreateServant
{

    public ?string $png = null;

    public function serve(): void
    {
        parent::serve();

        $file = fopen('php://memory', 'r+');

        imagepng($this->image, $file);

        rewind($file);

        $this->png = stream_get_contents($file);
    }

}
