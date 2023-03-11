<?php

declare(strict_types=1);

namespace SetCMS\Template;

use SetCMS\Contract\Template as TemplateInterface;

class Template implements TemplateInterface
{

    use \SetCMS\QuickTrait;
    use \SetCMS\EnvTrait;

    private TemplateInterface $engine;

    private function engine(): TemplateInterface
    {
        if (empty($this->engine)) {
            switch ($this->env()['TEMPLATE_ENGINE'] ?? null) {
                case 'twig':
                default:
                    $this->engine = TemplateTwig::make($this->factory());
            }
        }

        return $this->engine;
    }

    public function render(string $name, array $context = []): string
    {
        if (str_contains($name, '@')) {
            $name = explode('@', $name)[0];
        }

        return $this->engine()->render($name, $context);
    }
    
    public function from(object $object): void
    {
        $this->engine()->from($object);
    }

    
    public function to(object $object): void
    {
        $this->engine()->to($object);
    }
}
