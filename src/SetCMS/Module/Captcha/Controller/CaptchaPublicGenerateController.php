<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Controller;

use SetCMS\Module\Captcha\CaptchaEntity;
use SetCMS\Module\Captcha\Servant\CaptchaCreateAsPngServant;
use SetCMS\Module\Captcha\DAO\CaptchaSaveDAO;
use SetCMS\Attribute\Http\RequestMethod;
use SetCMS\Attribute\ResponderPassProperty;

#[RequestMethod('GET')]
class CaptchaPublicGenerateController extends \SetCMS\Controller
{

    private CaptchaEntity $captcha;

    #[ResponderPassProperty]
    protected ?string $id;

    #[ResponderPassProperty]
    protected ?string $content = null;

    #[\Override]
    protected function units(): array
    {
        return [
            CaptchaCreateAsPngServant::class,
            CaptchaSaveDAO::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof CaptchaCreateAsPngServant) {
            $this->content = base64_encode($object->png);
            $this->captcha = $object->captcha;
            $this->id = strval($object->captcha->id);
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CaptchaSaveDAO) {
            $object->captcha = $this->captcha;
        }
    }
}
