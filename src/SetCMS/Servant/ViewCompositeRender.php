<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Http\Message\ServerRequestInterface;

class ViewCompositeRender extends ViewHtmlRender
{

    public ?string $content = null;
    public ?string $contentType = null;
    public ServerRequestInterface $request;
    public string $context;


    #[\Override]
    protected function addFunction(string $name, \Closure $function): void
    {
        
    }

    #[\Override]
    protected function assign(string $name, mixed $value): void
    {
        $this->vars[$name] = $value;
    }

    #[\Override]
    protected function render(string $name, array $context = []): string
    {
        $content = null;
        $contentType = null;
        
        $file = $this->scLongPath($name);

        extract($this->vars);
        
        if (file_exists($file)) {
            require $file;
        }
        
        $this->content = $content;
        $this->contentType = $contentType;

        return $content ?? '';
    }

    protected function scLongPath(string $name): string
    {
        return sprintf('%s/resources/composite/%s', $this->basePath(), $this->scShortPath($name));
    }

    protected function scShortPath(string $name): string
    {
        if (substr($name, -4) !== '.php') {
            $name .= '.php';
        }

        return $name;
    }
}
