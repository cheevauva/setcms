<?php

declare(strict_types=1);

namespace Module\Captcha\DAO;

use Module\Captcha\Exception\CaptchaNotFoundException;
use Module\Captcha\Mapper\CaptchaFromRowMapper;
use Module\Captcha\CaptchaEntity;

class CaptchaRetrieveManyByCriteriaDAO extends \UUA\DAO
{

    use \SetCMS\DAO\DAOEntityRetrieveByCriteriaTrait;
    use \Module\Captcha\Traits\CaptchaDbalDAOTrait;

    /**
     * @var array<CaptchaEntity>
     */
    public array $captchas;
    public CaptchaEntity $captcha;
    public ?CaptchaEntity $captchaOrNull;

    #[\Override]
    protected function entitiesNotFoundException(): \Throwable
    {
        return new CaptchaNotFoundException;
    }

    #[\Override]
    protected function entityExpectOneButReceivedTooMuchException(): \Throwable
    {
        return new CaptchaNotFoundException;
    }

    #[\Override]
    protected function entityNotFoundException(): \Throwable
    {
        return new CaptchaNotFoundException;
    }

    #[\Override]
    protected function handleRows(array $rows): void
    {
        $this->captchas = array_map(fn($row) => CaptchaFromRowMapper::call($this->container, $row)->captcha, $rows);
        $this->captchas ? $this->captcha = $this->captchaOrNull = $this->captchas[0] : null;
    }
}
