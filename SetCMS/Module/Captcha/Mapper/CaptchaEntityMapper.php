<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Mapper;

use SetCMS\Module\Captcha\CaptchaEntity;

class CaptchaEntityMapper extends \SetCMS\Common\Mapper\EntityMapper
{

    protected function entity2row(): void
    {
        parent::entity2row();

        $entity = CaptchaEntity::as($this->entity);

        $this->row['text'] = $entity->text;
        $this->row['date_expiried'] = $entity->dateExpiried->format('Y-m-d H:i:s');
        $this->row['solve_attempts'] = $entity->solveAttempts;
        $this->row['is_used'] = (int) $entity->isUsed;
        $this->row['is_solved'] = (int) $entity->isSolved;
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $entity = CaptchaEntity::as($this->entity);
        $entity->text = strval($this->row['text'] ?? throw new \RuntimeException('row.text is undefined'));
        $entity->dateExpiried = new \DateTime(strval($this->row['date_expiried'] ?? throw new \RuntimeException('row.date_expiried is undefined')));
        $entity->isSolved = !empty($this->row['is_solved']);
        $entity->isUsed = !empty($this->row['is_used']);
        $entity->solveAttempts = intval($this->row['solve_attempts'] ?? throw new \RuntimeException('row.solve_attempts is undefined'));
    }
}
