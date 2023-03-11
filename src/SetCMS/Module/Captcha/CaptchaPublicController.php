<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Captcha\Scope\CaptchaGenerateScope;
use SetCMS\Module\Captcha\Scope\CaptchaSolveScope;
use SetCMS\Module\Captcha\Servant\CaptchaCreateAsPngAndStoreServant;
use SetCMS\Module\Captcha\Servant\CaptchaResolveServant;

class CaptchaPublicController
{

    use \SetCMS\ControllerTrait;

    public function solve(ServerRequestInterface $request, CaptchaSolveScope $scope, CaptchaResolveServant $servant): CaptchaSolveScope
    {
        return $this->serve($request, $servant, $scope, $request->getQueryParams());
    }

    public function generate(ServerRequestInterface $request, CaptchaGenerateScope $scope, CaptchaCreateAsPngAndStoreServant $servant): CaptchaGenerateScope
    {
        return $this->serve($request, $servant, $scope, []);
    }

}
