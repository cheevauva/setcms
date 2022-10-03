<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Mapper;

use SetCMS\Module\Captcha\CaptchaEntity;

class CaptchaEntityDbMapper extends \SetCMS\Entity\EntityDbMapper
{

    use \SetCMS\FactoryTrait;

    protected function entity(): CaptchaEntity
    {
        return parent::entity();
    }

    protected function entity2row(): void
    {
        parent::entity2row();

        $this->row['text'] = $this->entity()->text;
        $this->row['date_expiried'] = $this->entity()->dateExpiried->format('Y-m-d H:i:s');
        $this->row['solve_attempts'] = $this->entity()->solveAttempts;
        $this->row['is_used'] = (int) $this->entity()->isUsed;
        $this->row['is_solved'] = (int) $this->entity()->isSolved;
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $this->entity()->text = $this->row['text'];
        $this->entity()->dateExpiried = new \DateTime($this->row['date_expiried']);
        $this->entity()->isSolved = !empty($this->row['is_solved']);
        $this->entity()->isUsed = !empty($this->row['is_used']);
        $this->entity()->solveAttempts = (int) $this->row['solve_attempts'];
    }

}
