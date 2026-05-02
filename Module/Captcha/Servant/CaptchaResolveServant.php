<?php

declare(strict_types=1);

namespace Module\Captcha\Servant;

use SetCMS\UUID;
use Module\Captcha\CaptchaEntity;
use Module\Captcha\Servant\CaptchaByIdServant;
use Module\Captcha\DAO\CaptchaUpdateDAO;
use Module\Captcha\Exception\CaptchaUnsolvedException;

class CaptchaResolveServant extends \UUA\Servant
{

    public string $solvedText;
    public UUID $id;
    public protected(set) CaptchaEntity $captcha;

    #[\Override]
    public function serve(): void
    {
        $this->captcha = CaptchaByIdServant::call($this->container, $this->id)->captcha;
        $this->captcha->solve($this->solvedText);

        CaptchaUpdateDAO::call($this->container, $this->captcha);
        
        if (!$this->captcha->isSolved) {
            throw new CaptchaUnsolvedException();
        }
    }
}
