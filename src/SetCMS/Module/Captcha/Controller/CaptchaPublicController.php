<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Controller;

use SetCMS\Attribute\Http\RequestMethod;
use SetCMS\Module\Captcha\DAO\CaptchaRetrieveByIdDAO;
use SetCMS\Module\Captcha\Scope\CaptchaPublicGenerateScope;
use SetCMS\Module\Captcha\Scope\CaptchaPublicSolveScope;
use SetCMS\Module\Captcha\Servant\CaptchaCreateAsPngServant;
use SetCMS\Module\Captcha\Servant\CaptchaResolveServant;
use SetCMS\Module\Captcha\DAO\CaptchaSaveDAO;

class CaptchaPublicController
{

    use \SetCMS\Traits\ControllerTrait;

    #[RequestMethod('GET')]
    public function solve(CaptchaPublicSolveScope $scope): CaptchaPublicSolveScope
    {
        return $this->multiserve([
            CaptchaRetrieveByIdDAO::class,
            CaptchaResolveServant::class,
            CaptchaSaveDAO::class,
        ], $scope);
    }

    #[RequestMethod('GET')]
    public function generate(CaptchaPublicGenerateScope $scope): CaptchaPublicGenerateScope
    {
        return $this->multiserve([
            CaptchaCreateAsPngServant::class,
            CaptchaSaveDAO::class,
        ], $scope);
    }

}
