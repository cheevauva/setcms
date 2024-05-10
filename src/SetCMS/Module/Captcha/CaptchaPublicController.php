<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Captcha\DAO\CaptchaRetrieveByIdDAO;
use SetCMS\Module\Captcha\Scope\CaptchaPublicGenerateScope;
use SetCMS\Module\Captcha\Scope\CaptchaPublicSolveScope;
use SetCMS\Module\Captcha\Servant\CaptchaCreateAsPngServant;
use SetCMS\Module\Captcha\Servant\CaptchaResolveServant;
use SetCMS\Module\Captcha\DAO\CaptchaSaveDAO;

class CaptchaPublicController
{

    use \SetCMS\ControllerTrait;

    public function solve(ServerRequestInterface $request, CaptchaPublicSolveScope $scope): CaptchaPublicSolveScope
    {
        return $this->multiserve($request, [
            CaptchaRetrieveByIdDAO::class,
            CaptchaResolveServant::class,
            CaptchaSaveDAO::class,
        ], $scope);
    }

    public function generate(ServerRequestInterface $request, CaptchaPublicGenerateScope $scope): CaptchaPublicGenerateScope
    {
        return $this->multiserve($request, [
            CaptchaCreateAsPngServant::class,
            CaptchaSaveDAO::class,
        ], $scope);
    }

}
