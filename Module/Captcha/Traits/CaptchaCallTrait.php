<?php

declare(strict_types=1);

namespace Module\Captcha\Traits;

use Psr\Container\ContainerInterface;
use Module\Captcha\Entity\CaptchaEntity;

trait CaptchaCallTrait
{

    public CaptchaEntity $captcha;

    /**
     * @param ContainerInterface $container
     * @param CaptchaEntity $captcha
     * @return static
     */
    public static function call(ContainerInterface $container, CaptchaEntity $captcha): self
    {
        $self = self::new($container);
        $self->captcha = $captcha;
        $self->serve();

        return $self;
    }
}
