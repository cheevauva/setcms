<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\DAO;

use SetCMS\Module\Captcha\CaptchaEntity;
use SetCMS\Module\Captcha\Exception\CaptchaNotFoundException;

class CaptchaRetrieveByIdDAO extends \SetCMS\Entity\DAO\EntityRetrieveByIdDAO
{

    use CaptchaEntityDbDAOTrait;

    public ?CaptchaEntity $captcha = null;

    public function serve(): void
    {
        parent::serve();

        $this->captcha = $this->entity;
    }

    protected function createNotFoundException(): \Throwable
    {
        return new CaptchaNotFoundException;
    }

}
