<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\DAO;

use SetCMS\Module\Captcha\CaptchaEntity;

class CaptchaSaveDAO extends \SetCMS\Common\DAO\Entity\EntitySaveDAO
{

    
    use CaptchaCommonDAO;
    
    public CaptchaEntity $captcha;

    public function serve(): void
    {
        $this->entity = $this->captcha;
        
        parent::serve();
    }

}
