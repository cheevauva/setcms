<?php

declare(strict_types=1);

namespace SetCMS\View\Hook;

use Psr\Http\Message\ServerRequestInterface;
use Psr\EventDispatcher\StoppableEventInterface;

class ViewRenderHook implements StoppableEventInterface
{

    use \SetCMS\HookTrait;

    public mixed $data;
    public ServerRequestInterface $request;
    //
    public ?string $content = null;
    public ?string $contentType = null;

    public function isPropagationStopped(): bool
    {
        return !empty($this->content) && !empty($this->contentType);
    }

}
