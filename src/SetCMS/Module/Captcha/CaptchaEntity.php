<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha;

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
            throw CaptchaException::alreadyExpired();
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
            throw CaptchaException::alreadyUsed();
        }

        if (!$this->isSolved) {
            throw CaptchaException::unsolved();
        }

        $this->isUsed = true;
    }

    public function solve(string $solvedText): bool
    {
        $this->verifyDateExpiried();

        if ($this->isSolved) {
            throw CaptchaException::alreadySolved();
        }

        if ($this->solveAttempts > 5) {
            throw CaptchaException::tooMuchSolveAttempts();
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
