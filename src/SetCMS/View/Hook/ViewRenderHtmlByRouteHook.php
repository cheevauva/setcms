<?php

declare(strict_types=1);

namespace View\Hook;

class ViewRenderHtmlByRouteHook
{

    use \SetCMS\HookTrait;

    public string $route;
    public array $params = [];
    public ?string $template = null;
    public string $html;

}
