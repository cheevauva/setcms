<?php

namespace SetCMS\Module\Captcha;

use SetCMS\Module\Captcha\CaptchaDAO;
use SetCMS\Module\Captcha\Captcha;
use SetCMS\Module\Ordinary\OrdinaryService;
use SetCMS\Module\Captcha\CaptchaImage;

class CaptchaService extends OrdinaryService
{

    private CaptchaDAO $captchaDAO;

    public function __construct(CaptchaDAO $captchaDAO)
    {
        $this->captchaDAO = $captchaDAO;
    }

    public function solveCaptcha(string $id, string $solvedText): Captcha
    {
        $captcha = $this->dao()->get($id);
        $captcha->solve($solvedText);

        $this->dao()->save($captcha);

        return $captcha;
    }

    public function useSolvedCaptchaById(string $id): Captcha
    {
        $captcha = $this->dao()->get($id);
        $captcha->use();

        $this->dao()->save($captcha);

        return $captcha;
    }

    public function createCaptcha(): Captcha
    {
        $captcha = new Captcha;
        $captcha->content = (new CaptchaImage($captcha->text()))->toPNG();

        $this->dao()->save($captcha);

        return $captcha;
    }

    protected function dao(): CaptchaDAO
    {
        return $this->captchaDAO;
    }

    public function entity(): Captcha
    {
        return new Captcha;
    }

}
