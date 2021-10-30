<?php

namespace SetCMS\Module\Captcha;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Captcha\CaptchaModel\CaptchaModelGenerate;
use SetCMS\Module\Captcha\CaptchaModel\CaptchaModelSolve;
use SetCMS\Module\Captcha\CaptchaService;
use SetCMS\Module\Captcha\CaptchaException;

class CaptchaIndex
{

    private CaptchaService $captchaService;

    public function __construct(CaptchaService $captchaService)
    {
        $this->captchaService = $captchaService;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-json
     */
    public function solve(ServerRequestInterface $request, CaptchaModelSolve $model): CaptchaModelSolve
    {
        $model->fromArray($request->getQueryParams());

        if (!$model->isValid()) {
            return $model;
        }

        try {
            $captcha = $this->captchaService->solveCaptcha($model->id, $model->solvedText);
            
            if (!$captcha->isSolved) {
                $model->addMessage('Указан неверный код', 'solvedText');
            }
            
            $model->entity($captcha);
        } catch (CaptchaException $ex) {
            $model->addMessage($ex->getMessage());
        }

        return $model;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-json
     */
    public function generate(CaptchaModelGenerate $model): CaptchaModelGenerate
    {
        $model->entity($this->captchaService->createCaptcha());

        return $model;
    }

}
