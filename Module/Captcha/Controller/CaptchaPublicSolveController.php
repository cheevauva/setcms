<?php

declare(strict_types=1);

namespace Module\Captcha\Controller;

use SetCMS\UUID;
use Module\Captcha\Exception\CaptchaException;
use Module\Captcha\Servant\CaptchaResolveServant;
use Module\Captcha\CaptchaEntity;
use Module\Captcha\View\CaptchaPublicSolveView;

class CaptchaPublicSolveController extends \SetCMS\Controller\ControllerViaPSR7
{

    protected UUID $id;
    protected string $solvedText;
    protected CaptchaEntity $captcha;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
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
    protected function fromRequest(): void
    {
        $queryParams = $this->validationBody();

        $this->solvedText = $queryParams->string('solvedText')->notEmpty()->val();
        $this->id = $queryParams->uuid('id')->notEmpty()->val();
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
            $object->captcha = $this->captcha ?? null;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof CaptchaException) {
            $this->catch($object);
        }

        if ($object instanceof CaptchaResolveServant) {
            $this->captcha = $object->captcha;
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
