<?php

namespace SetCMS\Module\Captcha;

use SetCMS\Module\Ordinary\OrdinaryEntity;
use SetCMS\Module\Captcha\CaptchaException;

class Captcha extends OrdinaryEntity
{

    public bool $isSolved = false;
    public bool $isUsed = false;
    public int $solveAttempts = 0;
    public \DateTime $dateExpiried;
    private string $text;

    public function text(?string $text = null): string
    {
        if (!is_null($text)) {
            $this->text = $text;
        }

        return $this->text;
    }

    public static function generateText(): string
    {
        return rand(1000000, 9999999);
    }

    public function __construct()
    {
        parent::__construct();

        $this->dateExpiried = new \DateTime('+5 minutes');
        $this->text = Captcha::generateText();
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
