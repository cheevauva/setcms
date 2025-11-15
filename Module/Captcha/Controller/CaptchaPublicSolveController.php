<?php

declare(strict_types=1);

namespace Module\Captcha\Controller;

use SetCMS\UUID;
use Module\Captcha\Exception\CaptchaException;
use Module\Captcha\Servant\CaptchaResolveServant;
use Module\Captcha\DAO\CaptchaRetrieveManyByCriteriaDAO;
use Module\Captcha\DAO\CaptchaSaveDAO;
use Module\Captcha\CaptchaEntity;
use Module\Captcha\View\CaptchaPublicSolveView;

class CaptchaPublicSolveController extends \SetCMS\ControllerViaPSR7
{

    protected UUID $id;
    protected string $solvedText;
    protected CaptchaEntity $captcha;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            CaptchaRetrieveManyByCriteriaDAO::class,
            CaptchaResolveServant::class,
            CaptchaSaveDAO::class,
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
    protected function process(): void
    {
        $validation = $this->validation($this->request->getQueryParams());

        $this->solvedText = $validation->string('solvedText')->notEmpty()->val();
        $this->id = $validation->uuid('id')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CaptchaRetrieveManyByCriteriaDAO) {
            $object->id = $this->id;
            $object->orThrow = true;
        }

        if ($object instanceof CaptchaResolveServant) {
            $object->captcha = CaptchaEntity::as($this->captcha);
            $object->solvedText = $this->solvedText;
        }

        if ($object instanceof CaptchaSaveDAO) {
            $object->captcha = CaptchaEntity::as($this->captcha);
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

        if ($object instanceof CaptchaRetrieveManyByCriteriaDAO) {
            $this->captcha = CaptchaEntity::as($object->first);
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
