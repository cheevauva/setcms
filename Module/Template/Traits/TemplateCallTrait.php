<?php

declare(strict_types=1);

namespace Module\Template\Traits;

use Module\Template\Entity\TemplateEntity;
use Psr\Container\ContainerInterface;
use UUA\WithContainterInterface;

trait TemplateCallTrait
{

    public TemplateEntity $template;

    public static function call(WithContainterInterface|ContainerInterface $container, TemplateEntity $template): self
    {
        $self = self::new($container);
        $self->template = $template;
        $self->serve();

        return $self;
    }
}
