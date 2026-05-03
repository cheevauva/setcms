<?php

declare(strict_types=1);

namespace Module\Captcha\Servant;

use Module\Captcha\DAO\CaptchaRetrieveManyByCriteriaDAO;
use Module\Captcha\Entity\CaptchaEntity;

class CaptchaByIdServant extends \UUA\Servant
{

    use \SetCMS\Traits\TraitsCallWithUUID;
    
    public CaptchaEntity $captcha;

    #[\Override]
    public function serve(): void
    {
        $captchaById = CaptchaRetrieveManyByCriteriaDAO::new($this->container);
        $captchaById->id = $this->id;
        $captchaById->expectOne = true;
        $captchaById->allowEmptyResult = false;
        $captchaById->limit = 1;
        $captchaById->serve();
        
        $this->captcha = $captchaById->captcha;
    }
}
