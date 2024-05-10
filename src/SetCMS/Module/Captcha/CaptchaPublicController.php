<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Captcha\DAO\CaptchaRetrieveByIdDAO;
use SetCMS\Module\Captcha\Scope\CaptchaGenerateScope;
use SetCMS\Module\Captcha\Scope\CaptchaSolveScope;
use SetCMS\Module\Captcha\Servant\CaptchaCreateAsPngServant;
use SetCMS\Module\Captcha\Servant\CaptchaResolveServant;
use SetCMS\Module\Captcha\DAO\CaptchaSaveDAO;

class CaptchaPublicController
{

    use \SetCMS\ControllerTrait;

    public function solve(ServerRequestInterface $request, CaptchaSolveScope $scope): CaptchaSolveScope
    {
        return $this->multiserve($request, [
            CaptchaRetrieveByIdDAO::make($this->factory()),
            CaptchaResolveServant::make($this->factory()),
            CaptchaSaveDAO::make($this->factory()),
        ], $scope);
    }

    public function generate(ServerRequestInterface $request, CaptchaGenerateScope $scope): CaptchaGenerateScope
    {
        return $this->multiserve($request, [
            CaptchaCreateAsPngServant::make($this->factory()),
            CaptchaSaveDAO::make($this->factory()),
        ], $scope);
    }

}
