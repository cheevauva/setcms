<?php

namespace SetCMS\Module\Users;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelRead;
use SetCMS\Module\Users\UserService;
use SetCMS\Module\Users\UserModel\UserModelRegistration;
use SetCMS\Module\OAuth\OAuthService;
use SetCMS\Module\Users\UserModel\UserModelUserInfo;
use SetCMS\RequestAttribute;
use SetCMS\Module\Captcha\CaptchaService;
use SetCMS\HttpStatusCode\NotFound;

final class UserIndex
{

    private UserService $userService;
    private OAuthService $oauthService;
    private CaptchaService $captchaService;

    public function __construct(UserService $userService, OAuthService $oauthService, CaptchaService $captchaService)
    {
        $this->userService = $userService;
        $this->captchaService = $captchaService;
        $this->oauthService = $oauthService;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function profile(ServerRequestInterface $request, OrdinaryModelRead $model): OrdinaryModelRead
    {
        $user = $this->oauthService->getUserByAccessToken((string) $request->getAttribute(RequestAttribute::ACCESS_TOKEN));

        if ($model->isValid()) {
            $model->entity($user);
        }

        return $model;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-json
     * @setcms-wrapper-json-none
     */
    public function userinfo(ServerRequestInterface $request, UserModelUserInfo $model): UserModelUserInfo
    {
        $user = $this->oauthService->getUserByAccessToken((string) $request->getAttribute(RequestAttribute::ACCESS_TOKEN));

        $model->entity($user);

        return $model;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     * @setcms-need-not-auth
     */
    public function registration(UserModelRegistration $model): UserModelRegistration
    {
        return $model;
    }

    /**
     * @setcms-request-method-post
     * @setcms-response-content-json
     * @setcms-need-not-auth
     */
    public function doRegistration(ServerRequestInterface $request, UserModelRegistration $model): UserModelRegistration
    {
        $model->fromArray($request->getParsedBody());

        if (!$model->isValid()) {
            return $model;
        }

        try {
            $this->captchaService->useSolvedCaptchaById($model->captcha);
            $this->userService->registation($model);
        } catch (\Exception $ex) {
            $model->addMessage($ex instanceof NotFound ? 'Код не действителен, обновите картинку и введите код' : $ex->getMessage(), 'captcha');
        }

        return $model;
    }

}
