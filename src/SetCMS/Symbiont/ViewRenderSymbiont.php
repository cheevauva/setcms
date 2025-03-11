<?php

declare(strict_types=1);

namespace SetCMS\Symbiont;

use SetCMS\Servant\ViewCompositeRender;
use SetCMS\Servant\ViewJsonRender;
use SetCMS\Servant\ViewHtmlRender;
use SetCMS\View\Hook\ViewRenderHook;

class ViewRenderSymbiont extends \UUA\SymbiontCustomizer
{

    public function from(object $object): void
    {
        if ($object instanceof ViewRenderHook) {
            if ($this->master instanceof ViewJsonRender) {
                $master = ViewJsonRender::as($this->master);
                $master->mixedValue = $object->data;
                $master->request = $object->request;
            }

            if ($this->master instanceof ViewHtmlRender) {
                $master = ViewHtmlRender::as($this->master);
                $master->mixedValue = $object->data;
                $master->request = $object->request;
            }

            if ($this->master instanceof ViewCompositeRender) {
                $master = ViewCompositeRender::as($this->master);
                $master->mixedValue = $object->data;
                $master->request = $object->request;
            }
        }
    }

    public function to(object $object): void
    {
        if ($object instanceof ViewRenderHook) {
            if ($this->master instanceof ViewJsonRender) {
                $master = ViewJsonRender::as($this->master);
                $object->content = $master->json;
                $object->contentType = 'application/json';
            }
        }

        if ($object instanceof ViewRenderHook) {
            if ($this->master instanceof ViewHtmlRender) {
                $master = ViewHtmlRender::as($this->master);
                $object->content = $master->html;
                $object->contentType = 'text/html';
            }
        }

        if ($object instanceof ViewRenderHook) {
            if ($this->master instanceof ViewCompositeRender) {
                $master = ViewCompositeRender::as($this->master);
                $object->content = $master->content;
                $object->contentType = $master->contentType;
            }
        }
    }
}
