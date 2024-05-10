<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha;

use SetCMS\Module\Captcha\Exception\CaptchaAlreadyUsedException;
use SetCMS\Module\Captcha\Exception\CaptchaExpiredException;
use SetCMS\Module\Captcha\Exception\CaptchaUnsolvedException;
use SetCMS\Module\Captcha\Exception\CaptchaAlreadySolvedException;
use SetCMS\Module\Captcha\Exception\CaptchaTooMuchSolveAttemptsException;

class CaptchaEntity extends \SetCMS\Entity
{

    public bool $isSolved = false;
    public bool $isUsed = false;
    public int $solveAttempts = 0;
    public \DateTime $dateExpiried;
    public string $text;

    public function __construct()
    {
        parent::__construct();

        $this->dateExpiried = new \DateTime('+5 minutes');
        $this->text = strval(rand(1000000, 9999999));
    }

    protected function verifyDateExpiried()
    {
        if ($this->isExpiried()) {
            throw new CaptchaExpiredException;
        }
    }

    public function isExpiried(): bool
    {
        return (new \DateTime) > $this->dateExpiried;
    }

    public function use()
    {
        $this->verifyDateExpiried();

        if ($this->isUsed) {
            throw new CaptchaAlreadyUsedException;
        }

        if (!$this->isSolved) {
            throw new CaptchaUnsolvedException;
        }

        $this->isUsed = true;
    }

    public function solve(string $solvedText): bool
    {
        $this->verifyDateExpiried();

        if ($this->isSolved) {
            throw new CaptchaAlreadySolvedException;
        }

        if ($this->solveAttempts > 5) {
            throw new CaptchaTooMuchSolveAttemptsException;
        }

        if ($this->text === $solvedText) {
            $this->isSolved = true;
            $this->dateExpiried = new \DateTime('+5 minutes');
        } else {
            $this->isSolved = false;
            $this->solveAttempts++;
        }

        return $this->isSolved;
    }

}
