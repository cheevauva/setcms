<?php

declare(strict_types=1);

namespace Module\Captcha\Controller;

use SetCMS\UUID;
use Module\Captcha\Exception\CaptchaException;
use Module\Captcha\Servant\CaptchaResolveServant;
use Module\Captcha\Entity\CaptchaEntity;
use Module\Captcha\View\CaptchaPublicSolveView;
use Module\Captcha\Mapper\CaptchaSolveFromRequestMapper;

class CaptchaPublicSolveController extends \SetCMS\Controller\ControllerViaPSR7
{

    protected UUID $id;
    protected string $solvedText;
    protected CaptchaEntity $captcha;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            CaptchaSolveFromRequestMapper::class,
            CaptchaResolveServant::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            CaptchaPublicSolveView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CaptchaResolveServant) {
            $object->id = $this->id;
            $object->solvedText = $this->solvedText;
        }

        if ($object instanceof CaptchaPublicSolveView) {
            $object->captcha = $this->captcha;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof CaptchaResolveServant) {
            $this->captcha = $object->captcha;
        }

        if ($object instanceof CaptchaSolveFromRequestMapper) {
            $this->solvedText = $object->solvedText;
            $this->id = $object->id;
        }
    }

    #[\Override]
    protected function catch(\Throwable $object): void
    {
        if ($object instanceof CaptchaException) {
            $this->messages->attach($object, 'id');
        }
    }
}
