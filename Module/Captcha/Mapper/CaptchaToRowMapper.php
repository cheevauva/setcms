<?php

declare(strict_types=1);

namespace Module\Captcha\Mapper;

use Module\Captcha\Entity\CaptchaEntity;

class CaptchaToRowMapper extends \SetCMS\Entity\Mapper\EntityToRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $entity = CaptchaEntity::as($this->entity);

        $this->row['text'] = $entity->text;
        $this->row['date_expiried'] = $entity->dateExpiried->format('Y-m-d H:i:s');
        $this->row['solve_attempts'] = $entity->solveAttempts;
        $this->row['is_used'] = (int) $entity->isUsed;
        $this->row['is_solved'] = (int) $entity->isSolved;

        parent::run();
    }
}
