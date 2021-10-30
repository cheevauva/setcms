<?php

namespace SetCMS\Module\Captcha\CaptchaModel;

use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;

class CaptchaModelSolve extends OrdinaryModel
{

    /**
     * @setcms-required
     */
    public string $id = '';

    /**
     * @setcms-required
     */
    public string $solvedText = '';

}
