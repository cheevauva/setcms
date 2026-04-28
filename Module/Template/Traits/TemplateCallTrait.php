<?php

declare(strict_types=1);

namespace Module\Template\Traits;

use Module\Template\Entity\TemplateEntity;
use Psr\Container\ContainerInterface;

trait TemplateCallTrait
{

    public TemplateEntity $template;

    /**
     * @param ContainerInterface $container
     * @param TemplateEntity $template
     * @return static
     */
    public static function call(ContainerInterface $container, TemplateEntity $template): self
    {
        $self = self::new($container);
        $self->template = $template;
        $self->serve();

        return $self;
    }
}
