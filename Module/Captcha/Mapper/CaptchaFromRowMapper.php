<?php

declare(strict_types=1);

namespace Module\Captcha\Mapper;

use Module\Captcha\Entity\CaptchaEntity;
use Module\Captcha\Exception\CaptchaMapperNotFoundKeyInRowException;

class CaptchaFromRowMapper extends \SetCMS\Entity\Mapper\EntityFromRowMapper
{

    public protected(set) CaptchaEntity $captcha;

    #[\Override]
    public function serve(): void
    {
        $this->captcha = new CaptchaEntity();
        $this->captcha->text = $this->string('text');
        $this->captcha->dateExpiried = $this->dateTime('date_expiried');
        $this->captcha->isSolved = $this->bool('is_solved');
        $this->captcha->isUsed = $this->bool('is_used');
        $this->captcha->solveAttempts = $this->int('solve_attempts');
        $this->id($this->captcha);
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): CaptchaMapperNotFoundKeyInRowException
    {
        return new CaptchaMapperNotFoundKeyInRowException($key);
    }
}
