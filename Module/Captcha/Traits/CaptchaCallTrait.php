<?php

declare(strict_types=1);

namespace Module\Captcha\Traits;

use Psr\Container\ContainerInterface;
use UUA\WithContainterInterface;
use Module\Captcha\Entity\CaptchaEntity;

trait CaptchaCallTrait
{

    public CaptchaEntity $captcha;

    public static function call(WithContainterInterface|ContainerInterface $container, CaptchaEntity $captcha): self
    {
        $self = self::new($container);
        $self->captcha = $captcha;
        $self->serve();

        return $self;
    }
}
