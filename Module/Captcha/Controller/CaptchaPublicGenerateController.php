<?php

declare(strict_types=1);

namespace Module\Captcha\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Captcha\Entity\CaptchaEntity;
use Module\Captcha\DAO\CaptchaCreateDAO;
use Module\Captcha\View\CaptchaPublicGenerateView;

class CaptchaPublicGenerateController extends ControllerViaPSR7
{

    protected CaptchaEntity $entity;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            CaptchaCreateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            CaptchaPublicGenerateView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CaptchaCreateDAO) {
            $object->entity = new CaptchaEntity();
        }

        if ($object instanceof CaptchaPublicGenerateView) {
            $object->captcha = $this->entity;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof CaptchaCreateDAO) {
            $this->entity = $object->entity;
        }
    }
}
