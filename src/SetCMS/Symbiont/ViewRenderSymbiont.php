<?php

declare(strict_types=1);

namespace SetCMS\Symbiont;

use SetCMS\Servant\ViewCompositeRender;
use SetCMS\Servant\ViewJsonRender;
use SetCMS\Servant\ViewHtmlRender;
use SetCMS\View\Hook\ViewRenderHook;

class ViewRenderSymbiont extends \UUA\SymbiontCustomizer
{

    #[\Override]
    public function to(object $object): void
    {
        $master = ViewRenderHook::as($this->master);

        if ($object instanceof ViewJsonRender) {
            $object->mixedValue = $master->data;
            $object->request = $master->request;
        }

        if ($object instanceof ViewHtmlRender) {
            $object->mixedValue = $master->data;
            $object->request = $master->request;
        }

        if ($object instanceof ViewCompositeRender) {
            $object->mixedValue = $master->data;
            $object->request = $master->request;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        $master = ViewRenderHook::as($this->master);

        if ($object instanceof ViewHtmlRender) {
            $master->content = $object->html;
            $master->contentType = 'text/html';
        }

        if ($object instanceof ViewCompositeRender) {
            $master->content = $object->content ?? null;
            $master->contentType = $object->contentType ?? null;
        }

        if ($object instanceof ViewJsonRender) {
            $master->content = $object->json;
            $master->contentType = 'application/json';
        }
    }
}
