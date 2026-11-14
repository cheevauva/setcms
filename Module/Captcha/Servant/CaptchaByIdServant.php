<?php

declare(strict_types=1);

namespace Module\Captcha\Servant;

use Module\Captcha\DAO\CaptchaRetrieveManyByCriteriaDAO;
use SetCMS\Entity\Servant\EntityGetByIdServant;
use Module\Captcha\Entity\CaptchaEntity;

/**
 * @extends EntityGetByIdServant<CaptchaEntity>
 */
class CaptchaByIdServant extends EntityGetByIdServant
{

    #[\Override]
    protected function manyByCriteria(): CaptchaRetrieveManyByCriteriaDAO
    {
        return CaptchaRetrieveManyByCriteriaDAO::new($this);
    }
}
