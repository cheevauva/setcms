<?php

declare(strict_types=1);

namespace Module\Captcha\DAO;

use SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO;
use Module\Captcha\Mapper\CaptchaFromRowMapper;
use Module\Captcha\Entity\CaptchaEntity;

/**
 * @extends EntityRetrieveByCriteriaDAO<CaptchaEntity>
 */
class CaptchaRetrieveManyByCriteriaDAO extends EntityRetrieveByCriteriaDAO
{

    use \Module\Captcha\Traits\CaptchaDbalDAOTrait;

    #[\Override]
    protected function rowToEntity(array $row): CaptchaEntity
    {
        return CaptchaFromRowMapper::call($this, $row)->entity;
    }
}
