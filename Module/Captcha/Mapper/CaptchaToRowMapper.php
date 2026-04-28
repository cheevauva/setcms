<?php

declare(strict_types=1);

namespace Module\Captcha\Mapper;

class CaptchaToRowMapper extends \UUA\Mapper
{

    use \Module\Captcha\Traits\CaptchaCallTrait;
    use \SetCMS\Mapper\MapperEntityToRowTrait;

    #[\Override]
    public function serve(): void
    {
        $this->mappingDefault($this->captcha);
        $this->row['text'] = $this->captcha->text;
        $this->row['date_expiried'] = $this->captcha->dateExpiried->format('Y-m-d H:i:s');
        $this->row['solve_attempts'] = $this->captcha->solveAttempts;
        $this->row['is_used'] = (int) $this->captcha->isUsed;
        $this->row['is_solved'] = (int) $this->captcha->isSolved;
    }
}
