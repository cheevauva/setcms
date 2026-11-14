<?php

declare(strict_types=1);

namespace Module\Captcha\Mapper;

use Module\Captcha\Entity\CaptchaEntity;
use SetCMS\Entity\Mapper\EntityFromRowMapper;

/**
 * @extends EntityFromRowMapper<CaptchaEntity>
 */
class CaptchaFromRowMapper extends EntityFromRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $captcha = $this->entity = new CaptchaEntity();
        $captcha->text = $this->string('text');
        $captcha->dateExpiried = $this->dateTime('date_expiried');
        $captcha->isSolved = $this->bool('is_solved');
        $captcha->isUsed = $this->bool('is_used');
        $captcha->solveAttempts = $this->int('solve_attempts');

        parent::run();
    }
}
