<?php

namespace SetCMS\Module\User;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\ServerRequestAttribute;
use SetCMS\Module\User\Form\UserProfileForm;
use SetCMS\Module\User\Form\UserInfoForm;
use SetCMS\Module\User\Form\UserRegistrationForm;
use SetCMS\Module\User\Servant\UserEntityRetrieveByAccessTokenServant;
use SetCMS\Contract\Twigable;
use SetCMS\Module\User\UserEntity;

class UserPublicController
{

    use \SetCMS\Controller\ControllerTrait;

    public function profile(ServerRequestInterface $request, UserProfileForm $form, UserEntityRetrieveByAccessTokenServant $servant): UserProfileForm
    {
        $form = $this->serve($servant, $form, [
            'token' => $request->getAttribute(ServerRequestAttribute::ACCESS_TOKEN),
        ]);
        
        return $form;
    }

    public function userinfo(ServerRequestInterface $request, UserInfoForm $form, UserEntityRetrieveByAccessTokenServant $servant): UserInfoForm
    {
        return $this->serve($servant, $form, [
            'token' => $request->getAttribute(ServerRequestAttribute::ACCESS_TOKEN),
        ]);
    }

    public function registration(): UserRegistrationForm
    {
        return new class() extends UserRegistrationForm implements \SetCMS\Contract\Twigable {

            public function __construct()
            {
                $this->user = new UserEntity;
                $this->user->username = 'hello';
                $this->user->password('hello');
            }
        };
    }

    /**
     * @setcms-request-method-post
     * @setcms-response-content-json
     */
    public function doRegistration(ServerRequestInterface $request, UserRegistrationForm $model): UserRegistrationForm
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
